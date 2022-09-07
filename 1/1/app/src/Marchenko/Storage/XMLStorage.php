<?php

namespace Marchenko\Storage;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Marchenko\Config;
use Marchenko\Exception\XMLStorageException;
use Marchenko\Models\Item;

class XMLStorage implements Storagable
{

    private const CART = 'cart';
    private const ITEM = 'item';
    private const SKU = 'sku';
    private const QTY = 'qty';

    private DOMDocument $xml;
    private string $filePath;

    public function __construct()
    {
        $this->filePath = (Config::getInstance())->getParam("storage", "file_path");

        $this->initXmlFile();
    }

    public function insert(Item $item): bool
    {
        $root = $this->getRoot();
        if (empty($root)) {
            return false;
        }
        $elementItem = $this->wrapperCreateElement(self::ITEM);

        $buf = [
            ['name' => self::SKU , 'value' => $item->getSku()],
            ['name' => self::QTY , 'value' => $item->getQty()],
        ];
        foreach ($buf as $value) {
            $element = $this->wrapperCreateElement($value['name'], $value['value']);
            $result = $this->wrapperAppendChild($elementItem, $element);
        }

        $this->wrapperAppendChild($root, $elementItem);
        $this->saveFile();
        return true;
    }

    public function update(Item $item, int $newQty): ?Item
    {
        $node = $this->selectNode($item->getSku());
        if (empty($node) || !$node->hasChildNodes()) {
            return null;
        }
        foreach ($node->childNodes as $child) {
            if ($child->tagName == self::QTY) {
                break;
            }
        }
        if (!isset($child)) {
            throw new XMLStorageException("Can't update. Element <qty> does not exist.");
        }
        $child->nodeValue = $newQty;
        $this->saveFile();
        return new Item($item->getSku(), $newQty);
    }

    public function find(string $sku): ?Item
    {
        $node = $this->selectNode($sku);
        if (empty($node) || !$node->hasChildNodes()) {
            return null;
        }
        $data = [];
        $tags = [self::SKU, self::QTY];
        foreach ($tags as $tag) {
            foreach ($node->childNodes as $child) {
                if ($child->tagName == $tag) {
                    $data[$tag] = $child->nodeValue;
                }
            }
        }
        if (count($data) < count($tags)) {
            throw new XMLStorageException("Can't find. XML has wrong struct.");
        }
        return new Item($data[self::SKU], $data[self::QTY]);
    }

    public function delete(Item $item): bool
    {
        $node = $this->selectNode($item->getSku());
        if (empty($node)) {
            return false;
        }
        $root = $this->getRoot();
        $root->removeChild($node);
        $this->saveFile();
        return true;
    }

    private function selectNode(string $sku): ?DOMNode
    {
        $dom = $this->getXML();
        $xpath = new DOMXPath($dom);
        $expression = '//' . self::ITEM . '[' . self::SKU . '="' . $sku . '"]';
        $entity = $xpath->query($expression);
        if (empty($entity) || empty($entity->item(0))) {
            return null;
        }
        return $entity->item(0);
    }

    private function wrapperAppendChild(DOMNode $elementItem, DOMNode $element): DOMNode
    {
        $result = $elementItem->appendChild($element);
        if (empty($result)) {
            throw new XMLStorageException("Can't append element.");
        }
        return $result;
    }

    private function wrapperCreateElement(string $name, string $value = ""): DOMElement
    {
        $dom = $this->getXML();
        $element = $dom->createElement($name, $value);
        if (empty($element)) {
            throw new XMLStorageException("Can't create element " . $name);
        }
        return $element;
    }

    private function initXmlFile()
    {
        if (!file_exists($this->filePath)) {
            $dom = $this->getXML();
            $xmlRoot = $dom->createElement("cart");
            $xmlRoot = $dom->appendChild($xmlRoot);
            $result = $dom->save($this->filePath, LIBXML_NOEMPTYTAG);
            if (empty($result)) {
                throw new XMLStorageException("Can't init XML-file: " . $this->filePath);
            }
        }
        $dom = $this->getXML();
        $dom->load($this->filePath);
    }

    private function getXML(): DOMDocument
    {
        if (empty($this->xml)) {
            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->formatOutput = true;
            $dom->preserveWhiteSpace = false;
            $this->xml = $dom;
        }
        return $this->xml;
    }

    private function getRoot(): ?DOMNode
    {
        $dom = $this->getXML();
        $list = $dom->getElementsByTagName(self::CART);
        if (empty($list)) {
            return null;
        }
        $root = $list->item(0);
        if (empty($root)) {
            return null;
        }
        return $root;
    }

    private function saveFile()
    {
        $dom = $this->getXML();
        $saved = $dom->save($this->filePath);
        if (!$saved) {
            throw new XMLStorageException("Can't save XML-file:" . $this->filePath);
        }
    }

}