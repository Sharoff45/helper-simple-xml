<?php
namespace Sharoff\SimpleXml\Helper;

/**
 *
 * Class HelperSimpleXml
 * @package Sharoff\SimpleXml\Helper
 */
Class HelperSimpleXml {

    /**
     * Преобразовать массив в SimpleXmlElement
     *
     * @param        $data
     * @param        $root_element
     * @param null   $parent_xml
     * @param string $encoding
     *
     * @return null|\SimpleXMLElement
     */
    static function array2xml($data, $root_element = 'root', &$parent_xml = null, $encoding = 'UTF-8') {
        if (is_null($parent_xml)) {
            $parent_xml = new \SimpleXMLElement(
                '<?xml version="1.0" encoding="' . $encoding . '"?><' . $root_element . '/>'
            );
        }

        foreach ($data as $k => $v) {
            if ('@attributes' == $k) {
                $attributes = $v;
                foreach ($attributes as $attribute_name => $attribute_value) {
                    $parent_xml->addAttribute($attribute_name, $attribute_value);
                }
                continue;
            }
            if (is_array($v) || is_object($v)) {
                $v        = (array)$v;
                $keys     = array_keys($v);
                $filtered = array_filter(
                    $keys,
                    function ($key_name) {
                        return !(bool)is_numeric($key_name);
                    }
                );
                if (!count($filtered)) {
                    foreach ($v as $child_value) {
                        if (is_array($child_value)) {
                            $child = $parent_xml->addChild($k);
                            self::array2xml($child_value, null, $child, $encoding);
                            continue;
                        }
                        $parent_xml->addChild($k, $child_value);
                    }
                    continue;
                }
                $child = $parent_xml->addChild($k);
                self::array2xml($v, null, $child, $encoding);
            }
            else {
                $parent_xml->addChild($k, $v);
            }
        }

        return $parent_xml;
    }

    /**
     * Преобразовать SimpleXmlElement в красивый xml
     *
     * @param \SimpleXMLElement $xml
     * @param bool              $with_entity_decode
     *
     * @return string
     */
    static function beautyXml(\SimpleXMLElement $xml, $with_entity_decode = true) {
        $dom               = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        return $with_entity_decode ? html_entity_decode($dom->saveXML()) : $dom->saveXML();
    }

    /**
     * Преобразовать массив в красивый XML
     *
     * @param        $data
     * @param        $root_element
     * @param null   $parent_xml
     * @param string $encoding
     * @param bool   $with_entity_decode
     *
     * @return string
     */
    static function array2BeautyXml($data, $root_element = 'root', &$parent_xml = null, $encoding = 'UTF-8', $with_entity_decode = true) {
        $xml = self::array2xml($data, $root_element, $parent_xml, $encoding, $with_entity_decode);
        return self::beautyXml($xml, $with_entity_decode);
    }

}