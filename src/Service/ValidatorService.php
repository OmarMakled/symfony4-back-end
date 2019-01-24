<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Service;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    /**
     * TranslatorInterface instance.
     * 
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    public $translator;

    /**
     * ValidatorInterface instance.
     * 
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public $validator;

    /**
     * List of errors.
     * 
     * @var []
     */
    public $errors = [];

    /**
     * Constructor.
     * 
     * @param \Symfony\Component\Translation\TranslatorInterface        $translator
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(TranslatorInterface $translator, ValidatorInterface $validator)
    {
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * Validate an entity.
     * 
     * @param mixed $entity
     * 
     * @return bool
     */
    public function isValid($entity)
    {
        $this->errors = $this->validator->validate($entity);

        return !$this->hasError();
    }

    /**
     * Determine whether has error.
     * 
     * @return bool
     */
    public function hasError()
    {
        return (count($this->errors) > 0);
    }

    /**
     * Get errors.
     * 
     * @return []
     */
    public function getError()
    {
        $messages = [];
        foreach ($this->errors as $violation) {
            $messages[$violation->getPropertyPath()][] = $this->translate($violation->getMessage());
        }

        return $messages;
    }

    /**
     * Translate message.
     * 
     * @param string $string
     * 
     * @return string
     */
    private function translate($string)
    {
        return $this->translator->trans($string, [], 'validators');
    }

    /**
     * Get success message.
     * 
     * @return string
     */
    public function success()
    {
        return $this->translator->trans('success');
    }
}
