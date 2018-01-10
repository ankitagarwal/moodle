<?php

require_once ("config.php");

function get_pluginlist_for_gdpr() {
    $noncorepluginlist = ['compatible' => [] , 'notcompatible' => []];
    $plugintypes = \core_component::get_plugin_types();
    foreach ($plugintypes as $plugintype => $notused) {
        $pluginlist = \core_component::get_plugin_list($plugintype);
        foreach ($pluginlist as $plugin => $directory) {
            $fullpluginname = $plugintype . '_' . $plugin;
            $pluginclassname = '\\' . $fullpluginname . "\\gdpr";
            // Check that this is actually a class.
            if (class_exists($pluginclassname)) {
                $noncorepluginlist['compatible'][$fullpluginname] = $pluginclassname;
                continue;
            }
            // Backport location -
            $pluginclassname2 = '\\tool_gdpr\\' . $fullpluginname;
            if (class_exists($pluginclassname2)) {
                $noncorepluginlist['compatible'][$fullpluginname] = $pluginclassname2;
                continue;
            }
            $noncorepluginlist['notcompatible'][$fullpluginname] = [$pluginclassname, $pluginclassname2];
        }
    }
    return $noncorepluginlist;
}
echo "<br /><br /><br />List of non core plugins which are compatible <br /><br /><br />";
$noncorepluginlist = get_pluginlist_for_gdpr();
foreach($noncorepluginlist['compatible'] as $plugin => $classname) {
    echo "$plugin" . " ----------- " . $classname . "<br />";
}


echo "<br /><br /><br />List of non core plugins which are not compatible (class not found in either location) <br /><br /><br />";
foreach($noncorepluginlist['notcompatible'] as $plugin => $classnames) {
    echo "$plugin" . " ----------- " . $classnames[0] . " ----------- " . $classnames[1] ."<br />";
}