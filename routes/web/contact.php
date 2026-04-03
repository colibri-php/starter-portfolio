<?php

use Colibri\Http\Response;
use Colibri\Mail\Mail;

return [
    'GET' => function ($request, $params) {
        // Rendered by contact.latte twin
    },
    'POST' => function ($request, $params) {
        $errors = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required', ['lengthMin', 10]],
        ]);

        if ($errors) {
            return Response::back()
                ->with('error', t('contact.error'))
                ->withInput();
        }

        // Sends via SMTP in production (MAIL_DRIVER=smtp)
        // Logs to storage/logs/mail.log in development (MAIL_DRIVER=log)
        Mail::send(
            to: env('MAIL_FROM_ADDRESS', 'hello@janedoe.com'),
            subject: 'New contact: ' . $request->input('name'),
            template: base_path('templates/emails/contact.latte'),
            data: [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('message'),
            ],
        );

        return Response::redirect(url(path: 'contact'))
            ->with('success', t('contact.success'));
    },
];
