<?php

class TimeTracker_List_View extends Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->view('List.tpl', $request->getModule());
    }

    public function getHeaderScripts(Vtiger_Request $request) {
	    $allJS = parent::getHeaderScripts($request);
	    $moduleName = $request->getModule();

	    $jsFileNames = array(
            "modules.$moduleName.resources.js.angular",
            "modules.$moduleName.resources.js.moment",
            "modules.$moduleName.resources.js.angular-timer",
            "modules.$moduleName.resources.js.jspdf",
            "modules.$moduleName.resources.js.jspdf-standard-font-metrics",
            "modules.$moduleName.resources.js.jspdf-split-text-to-size",
            "modules.$moduleName.resources.js.jspdf-from-html",
            "modules.$moduleName.resources.js.jspdf-filesaver",
            "modules.$moduleName.resources.js.jspdf-addhtml",
            "modules.$moduleName.resources.js.jspdf-cell",
            "modules.$moduleName.resources.app"
	    );

	    $newJS = $this->checkAndConvertJsScripts($jsFileNames);
	    $allJS = array_merge($allJS, $newJS);
	    return $allJS;
    }

    public function getHeaderCss(Vtiger_Request $request) {
        $headerCssInstances = parent::getHeaderCss($request);
        $moduleName = $request->getModule();

        $cssFileNames = array(
            "~/layouts/vlayout/modules/TimeTracker/resources/css/style.css"
        );
        $cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
        $headerCssInstances = array_merge($headerCssInstances, $cssInstances);

        return $headerCssInstances;
    }

}
