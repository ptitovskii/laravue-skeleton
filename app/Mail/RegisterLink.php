<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Model\RegisterLink as Model;

class RegisterLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Create a new message instance.
     *
     * @param Model $model
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Регистрация')
            ->view('mail.register_link')
            ->with(
                [
                    'link' => $this->model->getLink(),
                ]
            );
    }
}
