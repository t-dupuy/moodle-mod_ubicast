<?php
/**
 * URL configuration form
 *
 * @package    mod
 * @subpackage ubicast
 * @copyright  2013 UbiCast {@link https://www.ubicast.eu}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) { die('Direct access to this script is forbidden.'); }

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/config.php');

class mod_ubicast_mod_form extends moodleform_mod {
    function definition() {
        global $CFG, $DB, $COURSE;
        $mform = $this->_form;

        $config = get_config('ubicast');

        //-------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $this->standard_intro_elements();

        //-------------------------------------------------------
        $mform->addElement('header', 'content', get_string('form_resource_header', 'ubicast'));
        $mform->addElement('text', 'mediaid', get_string('form_resource', 'ubicast'), array('size'=>'20'));
        $mform->addHelpButton('mediaid', 'form_resource', 'ubicast');
        $mform->addRule('mediaid', null, 'required', null, 'client');

        $config = get_config('ubicast');
        $tool_base_URL = $config->ubicast_url;

        $mform->addElement('html', '
            <div class="fitem">
                <div class="felement">
                    <div id="mod_ms_browser_preview">
                        <iframe style="width: 260px; height: 200px; margin: 0;" src="'.$CFG->wwwroot.'/mod/ubicast/statics/media.png" frameborder="0"></iframe>
                        <button type="button" onclick="javascript: media_selector.open();">'.get_string('form_resource_pick', 'ubicast').'</button>
                    </div>
                </div>
            </div>

            <link rel="stylesheet" type="text/css" href="'.$CFG->wwwroot.'/mod/ubicast/statics/odm/odm.css?_=7"/>
            <link rel="stylesheet" type="text/css" href="'.$CFG->wwwroot.'/mod/ubicast/statics/overlay.css?_=7"/>

            <script type="text/javascript" src="'.$CFG->wwwroot.'/mod/ubicast/statics/jquery.min.js?_=7"></script>
            <script type="text/javascript" src="'.$CFG->wwwroot.'/mod/ubicast/statics/utils.js?_=7"></script>
            <script type="text/javascript" src="'.$CFG->wwwroot.'/mod/ubicast/statics/odm/odm.js?_=7"></script>
            <script type="text/javascript" src="'.$CFG->wwwroot.'/mod/ubicast/statics/media_selector.js?_=7"></script>
            <script type="text/javascript">
                var media_selector = new MediaSelector({
                    moodleURL: "'.$CFG->wwwroot.'/mod/ubicast/lti.php?id='.$COURSE->id.'",
                    mediaserverURL: "'.$tool_base_URL.'",
                    title: "'.get_string('form_resource_pick', 'ubicast').'"
                });
            </script>');

        //-------------------------------------------------------
        $this->standard_coursemodule_elements();

        //-------------------------------------------------------
        $this->add_action_buttons();
    }
}
