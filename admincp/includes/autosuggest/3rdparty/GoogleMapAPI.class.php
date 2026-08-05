<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Project:     GoogleMapAPI: a PHP library inteface to the Google Map API
 * File:        GoogleMapAPI.class.php
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-general-subscribe@lists.php.net
 *
 * @link http://www.phpinsider.com/php/code/GoogleMapAPI/
 * @copyright 2005 New Digital Group, Inc.
 * @author Monte Ohrt <monte at ohrt dot com>
 * @package GoogleMapAPI
 * @version 2.5
 */
class GoogleMapAPI
{
    /**
     * PEAR::DB DSN for geocode caching. example:
     * $dsn = 'mysql://user:pass@localhost/dbname';
     *
     * @var string
     */
    public $dsn = NULL;
    /**
     * YOUR GooglMap API KEY for your site.
     * (http://maps.google.com/apis/maps/signup.html)
     *
     * @var string
     */
    public $api_key = "";
    /**
     * current map id, set when you instantiate
     * the GoogleMapAPI object.
     *
     * @var string
     */
    public $map_id = NULL;
    /**
     * sidebar <div> used along with this map.
     *
     * @var string
     */
    public $sidebar_id = NULL;
    /**
     * GoogleMapAPI uses the Yahoo geocode lookup API.
     * This is the application ID for YOUR application.
     * This is set upon instantiating the GoogleMapAPI object.
     * (http://developer.yahoo.net/faq/index.html#appid)
     *
     * @var string
     */
    public $app_id = NULL;
    /**
     * use onLoad() to load the map javascript.
     * if enabled, be sure to include on your webpage:
     * <html onload="onLoad()">
     *
     * @var string
     */
    public $onload = true;
    /**
     * map center latitude (horizontal)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    public $center_lat = NULL;
    /**
     * map center longitude (vertical)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    public $center_lon = NULL;
    /**
     * enables map controls (zoom/move/center)
     *
     * @var boolean
     */
    public $map_controls = true;
    /**
     * determines the map control type
     * small -> show move/center controls
     * large -> show move/center/zoom controls
     *
     * @var string
     */
    public $control_size = "large";
    /**
     * enables map type controls (map/satellite/hybrid)
     *
     * @var boolean
     */
    public $type_controls = true;
    /**
     * default map type (G_NORMAL_MAP/G_SATELLITE_MAP/G_HYBRID_MAP)
     *
     * @var boolean
     */
    public $map_type = "G_NORMAL_MAP";
    /**
     * enables scale map control
     *
     * @var boolean
     */
    public $scale_control = true;
    /**
     * enables overview map control
     *
     * @var boolean
     */
    public $overview_control = false;
    /**
     * determines the default zoom level
     *
     * @var integer
     */
    public $zoom = 16;
    /**
     * determines the map width
     *
     * @var integer
     */
    public $width = "500px";
    /**
     * determines the map height
     *
     * @var integer
     */
    public $height = "500px";
    /**
     * message that pops up when the browser is incompatible with Google Maps.
     * set to empty string to disable.
     *
     * @var integer
     */
    public $browser_alert = "Sorry, the Google Maps API is not compatible with this browser.";
    /**
     * message that appears when javascript is disabled.
     * set to empty string to disable.
     *
     * @var string
     */
    public $js_alert = "<b>Javascript must be enabled in order to use Google Maps.</b>";
    /**
     * determines if sidebar is enabled
     *
     * @var boolean
     */
    public $sidebar = true;
    /**
     * determines if to/from directions are included inside info window
     *
     * @var boolean
     */
    public $directions = true;
    /**
     * determines if map markers bring up an info window
     *
     * @var boolean
     */
    public $info_window = true;
    /**
     * determines if info window appears with a click or mouseover
     *
     * @var string click/mouseover
     */
    public $window_trigger = "click";
    /**
     * what server geocode lookups come from
     *
     * available: YAHOO  Yahoo! API. US geocode lookups only.
     *            GOOGLE Google Maps. This can do international lookups,
     *                   but not an official API service so no guarantees.
     *            Note: GOOGLE is the default lookup service, please read
     *                  the Yahoo! terms of service before using their API.
     *
     * @var string service name
     */
    public $lookup_service = "GOOGLE";
    public $lookup_server = ["GOOGLE" => "maps.google.com", "YAHOO" => "api.local.yahoo.com"];
    public $driving_dir_text = ["dir_to" => "Start address: (include addr, city st/region)", "to_button_value" => "Get Directions", "to_button_type" => "submit", "dir_from" => "End address: (include addr, city st/region)", "from_button_value" => "Get Directions", "from_button_type" => "submit", "dir_text" => "Directions: ", "dir_tohere" => "To here", "dir_fromhere" => "From here"];
    /**
     * version number
     *
     * @var string
     */
    public $_version = "2.5";
    /**
     * list of added markers
     *
     * @var array
     */
    public $_markers = [];
    /**
     * maximum longitude of all markers
     * 
     * @var float
     */
    public $_max_lon = -1000000;
    /**
     * minimum longitude of all markers
     *
     * @var float
     */
    public $_min_lon = 1000000;
    /**
     * max latitude
     *
     * @var float
     */
    public $_max_lat = -1000000;
    /**
     * min latitude
     *
     * @var float
     */
    public $_min_lat = 1000000;
    /**
     * determines if we should zoom to minimum level (above this->zoom value) that will encompass all markers
     *
     * @var boolean
     */
    public $zoom_encompass = true;
    /**
     * factor by which to fudge the boundaries so that when we zoom encompass, the markers aren't too close to the edge
     *
     * @var float
     */
    public $bounds_fudge = 0.01;
    /**
     * use the first suggestion by a google lookup if exact match not found
     *
     * @var float
     */
    public $use_suggest = false;
    /**
     * list of added polylines
     *
     * @var array
     */
    public $_polylines = [];
    /**
     * icon info array
     *
     * @var array
     */
    public $_icons = [];
    /**
     * database cache table name
     *
     * @var string
     */
    public $_db_cache_table = "GEOCODES";
    public function GoogleMapAPI($map_id = "map", $app_id = "MyMapApp")
    {
        $this->map_id = $map_id;
        $this->sidebar_id = "sidebar_" . $map_id;
        $this->app_id = $app_id;
    }
    public function setDSN($dsn)
    {
        $this->dsn = $dsn;
    }
    public function setAPIKey($key)
    {
        $this->api_key = $key;
    }
    public function setWidth($width)
    {
        if (!preg_match("!^(\\d+)(.*)\$!", $width, $_match)) {
            return false;
        }
        list($_width, $_type) = $_match;
        if ($_type == "%") {
            $this->width = $_width . "%";
        } else {
            $this->width = $_width . "px";
        }
        return true;
    }
    public function setHeight($height)
    {
        if (!preg_match("!^(\\d+)(.*)\$!", $height, $_match)) {
            return false;
        }
        list($_height, $_type) = $_match;
        if ($_type == "%") {
            $this->height = $_height . "%";
        } else {
            $this->height = $_height . "px";
        }
        return true;
    }
    public function setZoomLevel($level)
    {
        $this->zoom = (int) $level;
    }
    public function enableMapControls()
    {
        $this->map_controls = true;
    }
    public function disableMapControls()
    {
        $this->map_controls = false;
    }
    public function setControlSize($size)
    {
        if (in_array($size, ["large", "small"])) {
            $this->control_size = $size;
        }
    }
    public function enableTypeControls()
    {
        $this->type_controls = true;
    }
    public function disableTypeControls()
    {
        $this->type_controls = false;
    }
    public function setMapType($type)
    {
        switch ($type) {
            case "hybrid":
                $this->map_type = "G_HYBRID_MAP";
                break;
            case "satellite":
                $this->map_type = "G_SATELLITE_MAP";
                break;
            case "map":
            default:
                $this->map_type = "G_NORMAL_MAP";
        }
    }
    public function enableOnLoad()
    {
        $this->onload = true;
    }
    public function disableOnLoad()
    {
        $this->onload = false;
    }
    public function enableSidebar()
    {
        $this->sidebar = true;
    }
    public function disableSidebar()
    {
        $this->sidebar = false;
    }
    public function enableDirections()
    {
        $this->directions = true;
    }
    public function disableDirections()
    {
        $this->directions = false;
    }
    public function setBrowserAlert($message)
    {
        $this->browser_alert = $message;
    }
    public function setJSAlert($message)
    {
        $this->js_alert = $message;
    }
    public function enableInfoWindow()
    {
        $this->info_window = true;
    }
    public function disableInfoWindow()
    {
        $this->info_window = false;
    }
    public function setInfoWindowTrigger($type)
    {
        switch ($type) {
            case "mouseover":
                $this->window_trigger = "mouseover";
                break;
            default:
                $this->window_trigger = "click";
        }
    }
    public function enableZoomEncompass()
    {
        $this->zoom_encompass = true;
    }
    public function disableZoomEncompass()
    {
        $this->zoom_encompass = false;
    }
    public function setBoundsFudge($val)
    {
        $this->bounds_fudge = $val;
    }
    public function enableScaleControl()
    {
        $this->scale_control = true;
    }
    public function disableScaleControl()
    {
        $this->scale_control = false;
    }
    public function enableOverviewControl()
    {
        $this->overview_control = true;
    }
    public function disableOverviewControl()
    {
        $this->overview_control = false;
    }
    public function setLookupService($service)
    {
        switch ($service) {
            case "GOOGLE":
                $this->lookup_service = "GOOGLE";
                break;
            case "YAHOO":
            default:
                $this->lookup_service = "YAHOO";
        }
    }
    public function addMarkerByAddress($address, $title = "", $html = "", $tooltip = "")
    {
        if (($_geocode = $this->getGeocode($address)) === false) {
            return false;
        }
        return $this->addMarkerByCoords($_geocode["lon"], $_geocode["lat"], $title, $html, $tooltip);
    }
    public function addMarkerByCoords($lon, $lat, $title = "", $html = "", $tooltip = "")
    {
        $_marker["lon"] = $lon;
        $_marker["lat"] = $lat;
        $_marker["html"] = is_array($html) || 0 < strlen($html) ? $html : $title;
        $_marker["title"] = $title;
        $_marker["tooltip"] = $tooltip;
        $this->_markers[] = $_marker;
        $this->adjustCenterCoords($_marker["lon"], $_marker["lat"]);
        return count($this->_markers) - 1;
    }
    public function addPolyLineByAddress($address1, $address2, $color = "", $weight = 0, $opacity = 0)
    {
        if (($_geocode1 = $this->getGeocode($address1)) === false) {
            return false;
        }
        if (($_geocode2 = $this->getGeocode($address2)) === false) {
            return false;
        }
        return $this->addPolyLineByCoords($_geocode1["lon"], $_geocode1["lat"], $_geocode2["lon"], $_geocode2["lat"], $color, $weight, $opacity);
    }
    public function addPolyLineByCoords($lon1, $lat1, $lon2, $lat2, $color = "", $weight = 0, $opacity = 0)
    {
        $_polyline["lon1"] = $lon1;
        $_polyline["lat1"] = $lat1;
        $_polyline["lon2"] = $lon2;
        $_polyline["lat2"] = $lat2;
        $_polyline["color"] = $color;
        $_polyline["weight"] = $weight;
        $_polyline["opacity"] = $opacity;
        $this->_polylines[] = $_polyline;
        $this->adjustCenterCoords($_polyline["lon1"], $_polyline["lat1"]);
        $this->adjustCenterCoords($_polyline["lon2"], $_polyline["lat2"]);
        return count($this->_polylines) - 1;
    }
    public function adjustCenterCoords($lon, $lat)
    {
        if (strlen((string) $lon) == 0 || strlen((string) $lat) == 0) {
            return false;
        }
        $this->_max_lon = (double) max($lon, $this->_max_lon);
        $this->_min_lon = (double) min($lon, $this->_min_lon);
        $this->_max_lat = (double) max($lat, $this->_max_lat);
        $this->_min_lat = (double) min($lat, $this->_min_lat);
        $this->center_lon = (double) ($this->_min_lon + $this->_max_lon) / 2;
        $this->center_lat = (double) ($this->_min_lat + $this->_max_lat) / 2;
        return true;
    }
    public function setCenterCoords($lon, $lat)
    {
        $this->center_lat = (double) $lat;
        $this->center_lon = (double) $lon;
    }
    public function createMarkerIcon($iconImage, $iconShadowImage = "", $iconAnchorX = "x", $iconAnchorY = "x", $infoWindowAnchorX = "x", $infoWindowAnchorY = "x")
    {
        $_icon_image_path = strpos($iconImage, "http") === 0 ? $iconImage : $_SERVER["DOCUMENT_ROOT"] . $iconImage;
        if (!($_image_info = @getimagesize($_icon_image_path))) {
            exit("GoogleMapAPI:createMarkerIcon: Error reading image: " . $iconImage);
        }
        if ($iconShadowImage) {
            $_shadow_image_path = strpos($iconShadowImage, "http") === 0 ? $iconShadowImage : $_SERVER["DOCUMENT_ROOT"] . $iconShadowImage;
            if (!($_shadow_info = @getimagesize($_shadow_image_path))) {
                exit("GoogleMapAPI:createMarkerIcon: Error reading image: " . $iconShadowImage);
            }
        }
        if ($iconAnchorX === "x") {
            $iconAnchorX = (int) ($_image_info[0] / 2);
        }
        if ($iconAnchorY === "x") {
            $iconAnchorY = (int) ($_image_info[1] / 2);
        }
        if ($infoWindowAnchorX === "x") {
            $infoWindowAnchorX = (int) ($_image_info[0] / 2);
        }
        if ($infoWindowAnchorY === "x") {
            $infoWindowAnchorY = (int) ($_image_info[1] / 2);
        }
        $icon_info = ["image" => $iconImage, "iconWidth" => $_image_info[0], "iconHeight" => $_image_info[1], "iconAnchorX" => $iconAnchorX, "iconAnchorY" => $iconAnchorY, "infoWindowAnchorX" => $infoWindowAnchorX, "infoWindowAnchorY" => $infoWindowAnchorY];
        if ($iconShadowImage) {
            $icon_info = array_merge($icon_info, ["shadow" => $iconShadowImage, "shadowWidth" => $_shadow_info[0], "shadowHeight" => $_shadow_info[1]]);
        }
        return $icon_info;
    }
    public function setMarkerIcon($iconImage, $iconShadowImage = "", $iconAnchorX = "x", $iconAnchorY = "x", $infoWindowAnchorX = "x", $infoWindowAnchorY = "x")
    {
        $this->_icons = [$this->createMarkerIcon($iconImage, $iconShadowImage, $iconAnchorX, $iconAnchorY, $infoWindowAnchorX, $infoWindowAnchorY)];
    }
    public function addMarkerIcon($iconImage, $iconShadowImage = "", $iconAnchorX = "x", $iconAnchorY = "x", $infoWindowAnchorX = "x", $infoWindowAnchorY = "x")
    {
        $this->_icons[] = $this->createMarkerIcon($iconImage, $iconShadowImage, $iconAnchorX, $iconAnchorY, $infoWindowAnchorX, $infoWindowAnchorY);
        return count($this->_icons) - 1;
    }
    public function printHeaderJS()
    {
        echo $this->getHeaderJS();
    }
    public function getHeaderJS()
    {
        return sprintf("<script src=\"http://maps.google.com/maps?file=api&amp;v=3&amp;key=%s\" type=\"text/javascript\" charset=\"utf-8\"></script>", $this->api_key);
    }
    public function printOnLoad()
    {
        echo $this->getOnLoad();
    }
    public function getOnLoad()
    {
        return "<script language=\"javascript\" type=\"text/javascript\" charset=\"utf-8\">window.onload=onLoad;</script>";
    }
    public function printMapJS()
    {
        echo $this->getMapJS();
    }
    public function getMapJS()
    {
        $_output = "<script type=\"text/javascript\" charset=\"utf-8\">\n";
        $_output .= "//<![CDATA[\n";
        $_output .= "/*************************************************\n";
        $_output .= " * Created with GoogleMapAPI " . $this->_version . "\n";
        $_output .= " * Author: Monte Ohrt <monte AT ohrt DOT com>\n";
        $_output .= " * Copyright 2005-2006 New Digital Group\n";
        $_output .= " * http://www.phpinsider.com/php/code/GoogleMapAPI/\n";
        $_output .= " *************************************************/\n";
        $_output .= "var points = [];\n";
        $_output .= "var markers = [];\n";
        $_output .= "var counter = 0;\n";
        if ($this->sidebar) {
            $_output .= "var sidebar_html = \"\";\n";
            $_output .= "var marker_html = [];\n";
        }
        if ($this->directions) {
            $_output .= "var to_htmls = [];\n";
            $_output .= "var from_htmls = [];\n";
        }
        if (!empty($this->_icons)) {
            $_output .= "var icon = [];\n";
            $i = 0;
            for ($j = count($this->_icons); $i < $j; $i++) {
                $info = $this->_icons[$i];
                $icon_key = md5(serialize($info));
                if (!isset($exist_icn[$icon_key])) {
                    $_output .= "icon[" . $i . "] = new GIcon();\n";
                    $_output .= sprintf("icon[%s].image = \"%s\";", $i, $info["image"]) . "\n";
                    if ($info["shadow"]) {
                        $_output .= sprintf("icon[%s].shadow = \"%s\";", $i, $info["shadow"]) . "\n";
                        $_output .= sprintf("icon[%s].shadowSize = new GSize(%s,%s);", $i, $info["shadowWidth"], $info["shadowHeight"]) . "\n";
                    }
                    $_output .= sprintf("icon[%s].iconSize = new GSize(%s,%s);", $i, $info["iconWidth"], $info["iconHeight"]) . "\n";
                    $_output .= sprintf("icon[%s].iconAnchor = new GPoint(%s,%s);", $i, $info["iconAnchorX"], $info["iconAnchorY"]) . "\n";
                    $_output .= sprintf("icon[%s].infoWindowAnchor = new GPoint(%s,%s);", $i, $info["infoWindowAnchorX"], $info["infoWindowAnchorY"]) . "\n";
                } else {
                    $_output .= "icon[" . $i . "] = icon[" . $exist_icn[$icon_key] . "];\n";
                }
            }
        }
        $_output .= "var map = null;\n";
        if ($this->onload) {
            $_output .= "function onLoad() {\n";
        }
        if (!empty($this->browser_alert)) {
            $_output .= "if (GBrowserIsCompatible()) {\n";
        }
        $_output .= sprintf("var mapObj = document.getElementById(\"%s\");", $this->map_id) . "\n";
        $_output .= "if (mapObj != \"undefined\" && mapObj != null) {\n";
        $_output .= sprintf("map = new GMap2(document.getElementById(\"%s\"));", $this->map_id) . "\n";
        if (isset($this->center_lat) && isset($this->center_lon)) {
            $_output .= sprintf("map.setCenter(new GLatLng(%s, %s), %d, %s);", number_format($this->center_lat, 6, ".", ""), number_format($this->center_lon, 6, ".", ""), $this->zoom, $this->map_type) . "\n";
        }
        if ($this->zoom_encompass && 1 < count($this->_markers)) {
            $_len_lon = $this->_max_lon - $this->_min_lon;
            $_len_lat = $this->_max_lat - $this->_min_lat;
            $this->_min_lon -= $_len_lon * $this->bounds_fudge;
            $this->_max_lon += $_len_lon * $this->bounds_fudge;
            $this->_min_lat -= $_len_lat * $this->bounds_fudge;
            $this->_max_lat += $_len_lat * $this->bounds_fudge;
            $_output .= "var bds = new GLatLngBounds(new GLatLng(" . $this->_min_lat . ", " . $this->_min_lon . "), new GLatLng(" . $this->_max_lat . ", " . $this->_max_lon . "));\n";
            $_output .= "map.setZoom(map.getBoundsZoomLevel(bds));\n";
        }
        if ($this->map_controls) {
            if ($this->control_size == "large") {
                $_output .= "map.addControl(new GLargeMapControl());\n";
            } else {
                $_output .= "map.addControl(new GSmallMapControl());\n";
            }
        }
        if ($this->type_controls) {
            $_output .= "map.addControl(new GMapTypeControl());\n";
        }
        if ($this->scale_control) {
            $_output .= "map.addControl(new GScaleControl());\n";
        }
        if ($this->overview_control) {
            $_output .= "map.addControl(new GOverviewMapControl());\n";
        }
        $_output .= $this->getAddMarkersJS();
        $_output .= $this->getPolylineJS();
        if ($this->sidebar) {
            $_output .= sprintf("document.getElementById(\"%s\").innerHTML = \"<ul class=\\\"gmapSidebar\\\">\"+ sidebar_html +\"<\\/ul>\";", $this->sidebar_id) . "\n";
        }
        $_output .= "}\n";
        if (!empty($this->browser_alert)) {
            $_output .= "} else {\n";
            $_output .= "alert(\"" . str_replace("\"", "\\\"", $this->browser_alert) . "\");" . "\n";
            $_output .= "}\n";
        }
        if ($this->onload) {
            $_output .= "}\n";
        }
        $_output .= $this->getCreateMarkerJS();
        $_output .= "function isArray(a) {return isObject(a) && a.constructor == Array;}\n";
        $_output .= "function isObject(a) {return (a && typeof a == 'object') || isFunction(a);}\n";
        $_output .= "function isFunction(a) {return typeof a == 'function';}\n";
        if ($this->sidebar) {
            $_output .= "function click_sidebar(idx) {\n";
            $_output .= "  if(isArray(marker_html[idx])) { markers[idx].openInfoWindowTabsHtml(marker_html[idx]); }\n";
            $_output .= "  else { markers[idx].openInfoWindowHtml(marker_html[idx]); }\n";
            $_output .= "}\n";
        }
        $_output .= "function showInfoWindow(idx,html) {\n";
        $_output .= "map.centerAtLatLng(points[idx]);\n";
        $_output .= "markers[idx].openInfoWindowHtml(html);\n";
        $_output .= "}\n";
        if ($this->directions) {
            $_output .= "function tohere(idx) {\n";
            $_output .= "markers[idx].openInfoWindowHtml(to_htmls[idx]);\n";
            $_output .= "}\n";
            $_output .= "function fromhere(idx) {\n";
            $_output .= "markers[idx].openInfoWindowHtml(from_htmls[idx]);\n";
            $_output .= "}\n";
        }
        $_output .= "//]]>\n";
        $_output .= "</script>\n";
        return $_output;
    }
    public function getAddMarkersJS()
    {
        $SINGLE_TAB_WIDTH = 88;
        $i = 0;
        $_output = "";
        foreach ($this->_markers as $_marker) {
            if (is_array($_marker["html"])) {
                $ti = 0;
                $num_tabs = count($_marker["html"]);
                $tab_obs = [];
                foreach ($_marker["html"] as $tab => $info) {
                    if ($ti == 0 && 2 < $num_tabs) {
                        $width_style = sprintf(" style=\\\"width: %spx\\\"", $num_tabs * $SINGLE_TAB_WIDTH);
                    } else {
                        $width_style = "";
                    }
                    $tab = str_replace("\"", "\\\"", $tab);
                    $info = str_replace("\"", "\\\"", $info);
                    $info = str_replace(["\n", "\r"], "", $info);
                    $tab_obs[] = sprintf("new GInfoWindowTab(\"%s\", \"%s\")", $tab, "<div id=\\\"gmapmarker\\\"" . $width_style . ">" . $info . "</div>");
                    $ti++;
                }
                $iw_html = "[" . join(",", $tab_obs) . "]";
            } else {
                $iw_html = sprintf("\"%s\"", str_replace("\"", "\\\"", "<div id=\"gmapmarker\">" . str_replace(["\n", "\r"], "", $_marker["html"]) . "</div>"));
            }
            $_output .= sprintf("var point = new GLatLng(%s,%s);", $_marker["lat"], $_marker["lon"]) . "\n";
            $_output .= sprintf("var marker = createMarker(point,\"%s\",%s, %s,\"%s\");", str_replace("\"", "\\\"", $_marker["title"]), str_replace("/", "\\/", $iw_html), $i, str_replace("\"", "\\\"", $_marker["tooltip"])) . "\n";
            $_output .= "map.addOverlay(marker);\n";
            $i++;
        }
        return $_output;
    }
    public function getPolylineJS()
    {
        $_output = "";
        foreach ($this->_polylines as $_polyline) {
            $_output .= sprintf("var polyline = new GPolyline([new GLatLng(%s,%s),new GLatLng(%s,%s)],\"%s\",%s,%s);", $_polyline["lat1"], $_polyline["lon1"], $_polyline["lat2"], $_polyline["lon2"], $_polyline["color"], $_polyline["weight"], $_polyline["opacity"] / 0) . "\n";
            $_output .= "map.addOverlay(polyline);\n";
        }
        return $_output;
    }
    public function getCreateMarkerJS()
    {
        $_output = "function createMarker(point, title, html, n, tooltip) {\n";
        $_output .= "if(n >= " . sizeof($this->_icons) . ") { n = " . (sizeof($this->_icons) - 1) . "; }\n";
        if (!empty($this->_icons)) {
            $_output .= "var marker = new GMarker(point,{'icon': icon[n], 'title': tooltip});\n";
        } else {
            $_output .= "var marker = new GMarker(point,{'title': tooltip});\n";
        }
        if ($this->directions) {
            $_output .= "var tabFlag = isArray(html);\n";
            $_output .= "if(!tabFlag) { html = [{\"contentElem\": html}]; }\n";
            $_output .= sprintf("to_htmls[counter] = html[0].contentElem + '<form class=\"gmapDir\" id=\"gmapDirTo\" style=\"white-space: nowrap;\" action=\"http://maps.google.com/maps\" method=\"get\" target=\"_blank\">' +\n                     '<span class=\"gmapDirHead\" id=\"gmapDirHeadTo\">%s<strong>%s</strong> - <a href=\"javascript:fromhere(' + counter + ')\">%s</a></span>' +\n                     '<p class=\"gmapDirItem\" id=\"gmapDirItemTo\"><label for=\"gmapDirSaddr\" class=\"gmapDirLabel\" id=\"gmapDirLabelTo\">%s<br /></label>' +\n                     '<input type=\"text\" size=\"40\" maxlength=\"40\" name=\"saddr\" class=\"gmapTextBox\" id=\"gmapDirSaddr\" value=\"\" onfocus=\"this.style.backgroundColor = \\'#e0e0e0\\';\" onblur=\"this.style.backgroundColor = \\'#ffffff\\';\" />' +\n                     '<span class=\"gmapDirBtns\" id=\"gmapDirBtnsTo\"><input value=\"%s\" type=\"%s\" class=\"gmapDirButton\" id=\"gmapDirButtonTo\" /></span></p>' +\n                     '<input type=\"hidden\" name=\"daddr\" value=\"' +\n                     point.y + ',' + point.x + \"(\" + title.replace(new RegExp(/\"/g),'&quot;') + \")\" + '\" /></form>';\n                      from_htmls[counter] = html[0].contentElem + '<p /><form class=\"gmapDir\" id=\"gmapDirFrom\" style=\"white-space: nowrap;\" action=\"http://maps.google.com/maps\" method=\"get\" target=\"_blank\">' +\n                     '<span class=\"gmapDirHead\" id=\"gmapDirHeadFrom\">%s<a href=\"javascript:tohere(' + counter + ')\">%s</a> - <strong>%s</strong></span>' +\n                     '<p class=\"gmapDirItem\" id=\"gmapDirItemFrom\"><label for=\"gmapDirSaddr\" class=\"gmapDirLabel\" id=\"gmapDirLabelFrom\">%s<br /></label>' +\n                     '<input type=\"text\" size=\"40\" maxlength=\"40\" name=\"daddr\" class=\"gmapTextBox\" id=\"gmapDirSaddr\" value=\"\" onfocus=\"this.style.backgroundColor = \\'#e0e0e0\\';\" onblur=\"this.style.backgroundColor = \\'#ffffff\\';\" />' +\n                     '<span class=\"gmapDirBtns\" id=\"gmapDirBtnsFrom\"><input value=\"%s\" type=\"%s\" class=\"gmapDirButton\" id=\"gmapDirButtonFrom\" /></span></p>' +\n                     '<input type=\"hidden\" name=\"saddr\" value=\"' +\n                     point.y + ',' + point.x + encodeURIComponent(\"(\" + title.replace(new RegExp(/\"/g),'&quot;') + \")\") + '\" /></form>';\n                     html[0].contentElem = html[0].contentElem + '<p /><div id=\"gmapDirHead\" class=\"gmapDir\" style=\"white-space: nowrap;\">%s<a href=\"javascript:tohere(' + counter + ')\">%s</a> - <a href=\"javascript:fromhere(' + counter + ')\">%s</a></div>';\n", $this->driving_dir_text["dir_text"], $this->driving_dir_text["dir_tohere"], $this->driving_dir_text["dir_fromhere"], $this->driving_dir_text["dir_to"], $this->driving_dir_text["to_button_value"], $this->driving_dir_text["to_button_type"], $this->driving_dir_text["dir_text"], $this->driving_dir_text["dir_tohere"], $this->driving_dir_text["dir_fromhere"], $this->driving_dir_text["dir_from"], $this->driving_dir_text["from_button_value"], $this->driving_dir_text["from_button_type"], $this->driving_dir_text["dir_text"], $this->driving_dir_text["dir_tohere"], $this->driving_dir_text["dir_fromhere"]);
            $_output .= "if(!tabFlag) { html = html[0].contentElem; }";
        }
        if ($this->info_window) {
            $_output .= sprintf("if(isArray(html)) { GEvent.addListener(marker, \"%s\", function() { marker.openInfoWindowTabsHtml(html); }); }", $this->window_trigger) . "\n";
            $_output .= sprintf("else { GEvent.addListener(marker, \"%s\", function() { marker.openInfoWindowHtml(html); }); }", $this->window_trigger) . "\n";
        }
        $_output .= "points[counter] = point;\n";
        $_output .= "markers[counter] = marker;\n";
        if ($this->sidebar) {
            $_output .= "marker_html[counter] = html;\n";
            $_output .= "sidebar_html += '<li class=\"gmapSidebarItem\" id=\"gmapSidebarItem_'+ counter +'\"><a href=\"javascript:click_sidebar(' + counter + ')\">' + title + '<\\/a><\\/li>';\n";
        }
        $_output .= "counter++;\n";
        $_output .= "return marker;\n";
        $_output .= "}\n";
        return $_output;
    }
    public function printMap()
    {
        echo $this->getMap();
    }
    public function getMap()
    {
        $_output = "<script type=\"text/javascript\" charset=\"utf-8\">\n//<![CDATA[\n";
        $_output .= "if (GBrowserIsCompatible()) {\n";
        if (0 < strlen($this->width) && 0 < strlen($this->height)) {
            $_output .= sprintf("document.write('<div id=\"%s\" style=\"width: %s; height: %s\"><\\/div>');", $this->map_id, $this->width, $this->height) . "\n";
        } else {
            $_output .= sprintf("document.write('<div id=\"%s\"><\\/div>');", $this->map_id) . "\n";
        }
        $_output .= "}";
        if (!empty($this->js_alert)) {
            $_output .= " else {\n";
            $_output .= sprintf("document.write('%s');", str_replace("/", "\\/", $this->js_alert)) . "\n";
            $_output .= "}\n";
        }
        $_output .= "//]]>\n</script>\n";
        if (!empty($this->js_alert)) {
            $_output .= "<noscript>" . $this->js_alert . "</noscript>" . "\n";
        }
        return $_output;
    }
    public function printSidebar()
    {
        echo $this->getSidebar();
    }
    public function getSidebar()
    {
        return sprintf("<div id=\"%s\"></div>", $this->sidebar_id) . "\n";
    }
    public function getGeocode($address)
    {
        if (empty($address)) {
            return false;
        }
        $_geocode = false;
        if (($_geocode = $this->getCache($address)) === false && ($_geocode = $this->geoGetCoords($address)) !== false) {
            $this->putCache($address, $_geocode["lon"], $_geocode["lat"]);
        }
        return $_geocode;
    }
    public function getCache($address)
    {
        if (!isset($this->dsn)) {
            return false;
        }
        $_ret = [];
        require_once "DB.php";
        $_db =& DB::connect($this->dsn);
        if (PEAR::isError($_db)) {
            exit($_db->getMessage());
        }
        $_res =& $_db->query("SELECT lon,lat FROM " . $this->_db_cache_table . " where address = ?", $address);
        if (PEAR::isError($_res)) {
            exit($_res->getMessage());
        }
        if ($_row = $_res->fetchRow()) {
            list($_ret["lon"], $_ret["lat"]) = $_row;
        }
        $_db->disconnect();
        return !empty($_ret) ? $_ret : false;
    }
    public function putCache($address, $lon, $lat)
    {
        if (!isset($this->dsn) || strlen($address) == 0 || strlen($lon) == 0 || strlen($lat) == 0) {
            return false;
        }
        require_once "DB.php";
        $_db =& DB::connect($this->dsn);
        if (PEAR::isError($_db)) {
            exit($_db->getMessage());
        }
        $_res =& $_db->query("insert into " . $this->_db_cache_table . " values (?, ?, ?)", [$address, $lon, $lat]);
        if (PEAR::isError($_res)) {
            exit($_res->getMessage());
        }
        $_db->disconnect();
        return true;
    }
    public function geoGetCoords($address, $depth = 0)
    {
        switch ($this->lookup_service) {
            case "GOOGLE":
                $_url = sprintf("http://%s/maps/geo?&q=%s&output=csv&key=%s", $this->lookup_server["GOOGLE"], rawurlencode($address), $this->api_key);
                $_result = false;
                if ($_result = $this->fetchURL($_url)) {
                    $_result_parts = explode(",", $_result);
                    if ($_result_parts[0] != 200) {
                        return false;
                    }
                    list($_coords["lat"], $_coords["lon"]) = $_result_parts;
                }
                break;
            case "YAHOO":
            default:
                $_url = "http://%s/MapsService/V1/geocode";
                $_url .= sprintf("?appid=%s&location=%s", $this->lookup_server["YAHOO"], $this->app_id, rawurlencode($address));
                $_result = false;
                if ($_result = $this->fetchURL($_url)) {
                    preg_match("!<Latitude>(.*)</Latitude><Longitude>(.*)</Longitude>!U", $_result, $_match);
                    list($_coords["lat"], $_coords["lon"]) = $_match;
                }
                return $_coords;
        }
    }
    public function fetchURL($url)
    {
        return file_get_contents($url);
    }
    public function geoGetDistance($lat1, $lon1, $lat2, $lon2, $unit = "M")
    {
        $M = 0 * rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1 - $lon2))));
        strtoupper($unit);
        switch (strtoupper($unit)) {
            case "K":
                return $M * 0;
                break;
            case "N":
                return $M * 0;
                break;
            case "F":
                return $M * 5280;
                break;
            case "I":
                return $M * 63360;
                break;
            case "M":
            default:
                return $M;
        }
    }
}

?>