<?php

namespace App\Jobs;

use App\Mail\UserPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUserPassword implements ShouldQueue
{
    use Queueable;

    private string $email;
    private string $password;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email,string $password)
    {
        $this->set_password($password);
        $this->set_email($email);
    }

    public function set_email(string $email): void
    {
        $this->email = $email;
    }

    public function set_password(string $password): void
    {
        $this->password = $password;
    }

    public function get_email(): string
    {
        return $this->email;
    }

    public function get_password(): string
    {
        return $this->password;
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->get_email())->send(new UserPasswordMail($this->get_password()));
    }
}
