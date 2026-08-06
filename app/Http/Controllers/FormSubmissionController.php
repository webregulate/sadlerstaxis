<?php

namespace App\Http\Controllers;

use App\Mail\FormSubmissionNotification;
use App\Models\Form as FormModel;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class FormSubmissionController extends Controller
{
    public function store(Request $request, FormModel $form): RedirectResponse
    {
        $rules = [];

        foreach ($form->fields as $field) {
            if (($field['type'] ?? null) === 'heading' || empty($field['name'])) {
                continue;
            }

            $fieldRules = [($field['required'] ?? false) ? 'required' : 'nullable'];
            $fieldRules[] = ($field['type'] ?? null) === 'email' ? 'email' : 'string';

            if (($field['type'] ?? null) === 'checkbox') {
                $fieldRules = ['nullable', 'boolean'];
            }

            $rules[$field['name']] = $fieldRules;
        }

        $validated = $request->validate($rules);

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => $validated,
        ]);

        if ($form->notify_email) {
            try {
                Mail::to($form->notify_email)->send(new FormSubmissionNotification($form, $validated));
            } catch (Throwable $e) {
                // The submission is already saved above; don't fail the user's request over an email hiccup.
                Log::error('Form notification email failed: '.$e->getMessage());
            }
        }

        return back()
            ->with('form_submitted', $form->id)
            ->with('form_confirmation_message', $form->confirmation_message ?: 'Thank you — we will be in touch shortly.');
    }
}
