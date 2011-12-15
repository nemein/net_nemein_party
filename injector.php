<?php
/**
 * @package net_nemein_party
 * @author Ferenc Szekely
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class net_nemein_party_injector
{
    var $mvc = null;
    var $request = null;

    public function __construct()
    {
        $this->mvc = midgardmvc_core::get_instance();

        $this->mvc->i18n->set_translation_domain('net_nemein_party');

        $default_language = $this->mvc->configuration->default_language;

        if (! isset($default_language))
        {
            $default_language = 'en_US';
        }

        $this->mvc->i18n->set_language($default_language, false);
    }

    /**
     * @todo: docs
     */
    public function inject_process(midgardmvc_core_request $request)
    {
        $request->add_component_to_chain($this->mvc->component->get('net_nemein_party'), true);
        $this->mvc->head->set_title($this->mvc->i18n->get('title_welcome_to_the_party'));
    }

    /**
     * Some template hack
     */
    public function inject_template(midgardmvc_core_request $request)
    {
    }
}
?>
