<?php
/**
 * @package net_nemein_party
 * @author Ferenc Szekely
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Index controller
 */
class net_nemein_party_controllers_index extends midgardmvc_core_controllers_baseclasses_crud
{
    var $mvc = null;
    var $request = null;
    var $component = 'net_nemein_party';

    public function __construct(midgardmvc_core_request $request)
    {
        parent::__construct($request);
        $this->mvc = midgardmvc_core::get_instance();
        $this->mvc->i18n->set_translation_domain($this->component);
    }

    /**
     * @todo: docs
     */
    public function load_object(array $args)
    {
    }

    /**
     * @todo: docs
     */
    public function prepare_new_object(array $args)
    {
    }

    /**
     * @todo: docs
     */
    public function get_url_read()
    {
    }

    /**
     * @todo: docs
     */
    public function get_url_update()
    {
    }

    /**
     * @todo: docs
     */
    public function post_index(array $args)
    {
    }

    /**
     * @todo: docs
     */
    public function get_index(array $args)
    {
        if (isset($this->mvc->configuration->languages))
        {
            $this->data['languages'] = $this->mvc->configuration->languages;
        }
        else
        {
            $this->data['languages'] = array ($this->mvc->configuration->get('default_language'));
        }

        $this->data['label_language'] = '';

        foreach($this->data['languages'] as $lang)
        {
            $this->mvc->i18n->set_language($lang, false);
            $this->data['intro'][$lang]['lang_id'] = $lang;
            $this->data['intro'][$lang]['language'] = $this->mvc->i18n->get('language');
            $this->data['intro'][$lang]['greeting'] = $this->mvc->i18n->get('title_greeting');
            $this->data['intro'][$lang]['pick_language'] = $this->mvc->i18n->get('label_pick_language');
            $this->data['label_language'] .= $this->mvc->i18n->get('label_language') . ' / ';
        }
        $this->data['label_language'] = rtrim(rtrim($this->data['label_language']), '/');
    }

    /**
     * Handler for returning step 2
     * Sets the language.
     */
    public function get_language(array $args)
    {
        if (array_key_exists('language', $args))
        {
            $this->mvc->i18n->set_language($args['language'], false);
        }
        $current_language = $this->mvc->i18n->get_language();
        $this->data['lang'] = $current_language;

        if (isset($this->mvc->configuration->languages))
        {
            $this->data['languages'] = $this->mvc->configuration->languages;
        }
        else
        {
            $this->data['languages'] = array ($this->mvc->configuration->default_language);
        }

        $component = $this->component;

        if (strlen($this->mvc->configuration->special))
        {
            $component = $this->mvc->configuration->special;
        }

        $this->data['intro'] = $this->mvc->i18n->get('text_intro', $component);
        $this->data['programs'] = $this->mvc->i18n->get('text_programs', $component);

        $this->data['in_languages'] = array();

        foreach($this->data['languages'] as $lang)
        {
            if ($lang == $current_language)
            {
                continue;
            }
            $this->mvc->i18n->set_language($lang, false);
            $this->data['in_languages'][$lang]['lang_id'] = $lang;
            $this->data['in_languages'][$lang]['in_language'] = $this->mvc->i18n->get('label_in_language');
        }

        $this->data['rsvp_by'] = $this->mvc->configuration->rsvp_by;
        $this->data['contact'] = $this->mvc->configuration->contact;

        $this->mvc->i18n->set_language($current_language, false);
    }

    /**
     * Handler for receiving the language via AJAX
     * Sets the language.
     */
    public function post_language(array $args)
    {
        if (count($_POST))
        {
            if (array_key_exists('lang', $_POST))
            {
                $this->mvc->i18n->set_language($_POST['lang'], false);
                $this->data['page'] = $this->mvc->templating->dynamic_load('net_nemein_party', 'step2', array('language' => $_POST['lang']), true);
            }
        }
    }

    /**
     * Handler for returning step 3
     */
    public function get_register(array $args)
    {
        $component = $this->component;
        if (strlen($this->mvc->configuration->special))
        {
            $component = $this->mvc->configuration->special;
        }

        $attending = 0;
        if (array_key_exists('attending', $args))
        {
            $attending = $args['attending'];
        }

        if ($attending)
        {
            $this->data['feedback'] = $this->mvc->i18n->get('title_registration_success');
            $this->data['feedback'] .= $this->mvc->i18n->get('title_registration_welcome', $component);
        }
        else
        {
            $this->data['feedback'] = $this->mvc->i18n->get('title_registration_thank_for_notificaton');
        }
    }

    /**
     * Receives the contact info and saves it to the db
     */
    public function post_register(array $args)
    {
        $retval = false;

        if (   array_key_exists('firstname', $_POST)
            || array_key_exists('lastname', $_POST)
            || array_key_exists('email', $_POST))
        {
            // save the data
            $registration = new net_nemein_party_registration();
            $registration->firstname = $_POST['firstname'];
            $registration->lastname = $_POST['lastname'];
            $registration->email = $_POST['email'];
            $registration->attending = $_POST['rsvp'];

            $retval = $registration->create();

            if ($retval)
            {
                // check if had avec
                if ($_POST['avec'])
                {
                    $guest = new net_nemein_party_registration();
                    $guest->firstname = $_POST['guest_firstname'];
                    $guest->lastname = $_POST['guest_lastname'];
                    $guest->parent = $registration->guid;

                    $retval = $guest->create();
                }
            }

            if ($retval)
            {
                // set the response page
                $rsvp = (int) $_POST['rsvp'];
                $this->data['page'] = $this->mvc->templating->dynamic_load('net_nemein_party', 'step3', array('attending' => $rsvp), true);
            }
            else
            {
                // hmm, what to do
            }
        }
    }
}
?>