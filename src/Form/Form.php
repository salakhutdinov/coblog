<?php

namespace Coblog\Form;

use Coblog\Http\Request;

class Form
{
    private $options;

    private $fields = [];

    private $data = [];

    private $binded = false;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function getOption($key, $default)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : $default;
    }

    public function getMethod()
    {
        return $this->getOption('method', Request::METHOD_GET);
    }

    public function getAction()
    {
        return $this->getOption('action', '');
    }

    public function addField($name, $type, $attributes)
    {
        $field = new Field($name, $type, $attributes);

        $this->fields[$name] = $field;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function bindRequest(Request $request)
    {
        if (!$request->isMethod($this->getMethod())) {
            return;
        }

        foreach ($this->fields as $name => $field) {
            if ($request->isMethod(Request::METHOD_GET)) {
                $this->data[$name] = $request->get->get($name);
            } elseif ($request->isMethod(Request::METHOD_POST)) {
                $this->data[$name] = $request->post->get($name);
            } else {
                throw new \Exception('Only GET and POST methods are supported.');
            }
            $field->setValue($this->data[$name]);
        }

        $this->binded = true;
    }

    public function getData()
    {
        return $this->data;
    }

    public function isValid()
    {
        if (!$this->binded) {
            return false;
        }

        $valid = true;
        foreach ($this->fields as $name => $field) {
            if ($field->isRequired() && empty($this->data[$name])) {
                $field->addError('This field is required.');
                $valid = false;
            }
        }

        return $valid;
    }
}
