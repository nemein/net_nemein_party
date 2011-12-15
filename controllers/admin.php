<?php
/**
 * @package net_nemein_party
 * @author Ferenc Szekely
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class net_nemein_party_controllers_admin extends midgardmvc_core_controllers_baseclasses_crud
{
    $mvc = null;
    $request = null;
    $config = null;

    /**
     * @todo: docs
     */
    public function __construct(midgardmvc_core_request $request)
    {
        $this->mvc = midgardmvc_core::get_instance();
        $this->mvc->authorization->require_do('midgard:admin', '');

        $this->request = $request;
        $this->request->steps = $this->request->argv;

        $this->config = $this->request->get_component()->get_configuration();
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
     * Return the CSV output
     */
    public function get_csv(array $args)
    {
    }
}
?>