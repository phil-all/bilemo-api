<?php

namespace App\Service\FormErrorConvertor;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Get constraints form errors in array for controller JsonResponse.
 * @package App\Service\FormErrorConvertor;
 */
class FormValidationHandler
{
    /**
     * @var FormInterface
     */
    private FormInterface $form;

    /**
     * Get JsonResponse whether the form and all children are invalid.
     *
     * @param FormInterface $form
     *
     * @return JsonResponse|null
     */
    public function unvalidate(FormInterface $form): ?JsonResponse
    {
        $this->form = $form;

        return new JsonResponse($this->getFormErrors(), 400);
    }

    /**
     * Get form errors
     *
     * @return array
     */
    public function getFormErrors(): array
    {
        return [
            'type' => 'Validation Failed',
            'title' => 'Invalid request',
            'validation errors' => $this->errorsSerializer($this->form)
        ];
    }

    /**
     * Serialize form errors
     *
     * @return array
     */
    public function errorsSerializer(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->errorsSerializer($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
