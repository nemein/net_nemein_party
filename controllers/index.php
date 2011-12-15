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
    $mvc = null;
    $request = null;
    $config = null;

    public function __construct(midgardmvc_core_request $request)
    {
        parent::__construct($request);
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
    }
}
?>