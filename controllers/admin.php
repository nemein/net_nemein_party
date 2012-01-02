<?php
/**
 * @package net_nemein_party
 * @author Ferenc Szekely
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class net_nemein_party_controllers_admin extends midgardmvc_core_controllers_baseclasses_crud
{
    var $mvc = null;
    var $config = null;
    var $request = null;

    /**
     * @todo: docs
     */
    public function __construct(midgardmvc_core_request $request)
    {
        $retval = false;
        $this->mvc = midgardmvc_core::get_instance();
        $this->request = $request;
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
     * Prepares the data to be returned
     */
    private function prepare_data()
    {
        $storage = new midgard_query_storage('net_nemein_party_registration');
        $q = new midgard_query_select($storage);
        $q->execute();
        $registrations = $q->list_objects();

        $this->data['guests'] = array();

        if (count($registrations))
        {
            $this->data['guests']['header'][] = 'firstname';
            $this->data['guests']['header'][] = 'lastname';
            $this->data['guests']['header'][] = 'email';
            $this->data['guests']['header'][] = 'attending';
            $this->data['guests']['header'][] = 'avec';
            $this->data['guests']['header'][] = 'avec_firstname';
            $this->data['guests']['header'][] = 'avec_lastname';
            $this->data['guests']['header'][] = 'registered';

            foreach ($registrations as $registration)
            {
                $avec_firstname = '';
                $avec_lastname = '';

                if ($registration->parent)
                {
                    $parent = new net_nemein_party_registration($registration->parent);
                    if (is_object($parent))
                    {
                        $guest = $parent;
                        $avec_firstname = $registration->firstname;
                        $avec_lastname = $registration->lastname;
                    }
                    unset($parent);
                }
                else
                {
                    $guest = $registration;
                }

                $this->data['guests'][$guest->guid]['firstname'] = $guest->firstname;
                $this->data['guests'][$guest->guid]['lastname'] = $guest->lastname;
                $this->data['guests'][$guest->guid]['email'] = $guest->email;
                $this->data['guests'][$guest->guid]['attending'] = ($guest->attending) ? 'yes' : 'no';
                $this->data['guests'][$guest->guid]['avec'] = ($guest->avec) ? 'yes' : 'no';
                $this->data['guests'][$guest->guid]['avec_firstname'] = $avec_firstname;
                $this->data['guests'][$guest->guid]['avec_lastname'] = $avec_lastname;
                $this->data['guests'][$guest->guid]['registered'] = $guest->metadata->created->format('Y-m-d H:i:s');
            }
        }
    }

    /**
     * Return the CSV output
     */
    public function get_csv(array $args)
    {
        $this->mvc->authorization->require_admin();
        $this->prepare_data();
    }

    /**
     * Return the CSV output
     */
    public function post_csv(array $args)
    {
        $this->mvc->authorization->require_admin();
        $this->prepare_data();
    }
}
?>