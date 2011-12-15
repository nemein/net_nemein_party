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
    var $config = null;
    var $request = null;

    public function __construct()
    {
        $this->mvc = midgardmvc_core::get_instance();
    }

    /**
     * @todo: docs
     */
    public function inject_process(midgardmvc_core_request $request)
    {
        $request->add_component_to_chain($this->mvc->component->get('net_nemein_party'), true);
    }

    /**
     * Some template hack
     */
    public function inject_template(midgardmvc_core_request $request)
    {
        $this->mvc->head->enable_jquery();
        $this->mvc->head->enable_jquery_ui();
        $this->add_head_elements();
    }

     /**
     * Adds js and css files to head
     */
    private function add_head_elements()
    {
        $this->mvc->head->add_jsfile(MIDGARDMVC_STATIC_URL . '/net_nemein_party/js/party.js');
        $this->mvc->head->add_link (
            array
            (
                'rel' => 'stylesheet',
                'type' => 'text/css',
                'href' => MIDGARDMVC_STATIC_URL . '/net_nemein_party/css/party.css'
            )
        );
    }
}
?>
