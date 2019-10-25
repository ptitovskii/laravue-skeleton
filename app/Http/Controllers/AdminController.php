<?php

namespace App\Http\Controllers;

use App\Models\RegisterToken;
use App\Services\Goal;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterLink;
use App\Mail\Model\RegisterLink as RegisterLinkModel;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     *
     * @return View
     */
    public function index()
    {
        return view(
            'admin/index',
            []
        );
    }

    public function sendRegisterLink()
    {
        if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

            }
            else {
                $tmpName = $_FILES['file']['tmp_name'];
                $emails = array_map('str_getcsv', file($tmpName));
                $processedItems = 0;

                foreach ($emails as $email) {
                    $email = reset($email);
                    $token = Str::random(25);
                    $model = new RegisterToken();
                    $model->setEmail($email)
                        ->setToken($token)
                        ->save();

                    $this->sendEmailWithRegisterLink($email, $token);
                    $processedItems++;
                }

                return view(
                    'admin/register-link-form',
                    [
                        'processedItems' => $processedItems
                    ]
                );
            }
        } else {
            echo "No file selected <br />";
        }
    }

    protected function sendEmailWithRegisterLink(string $email, string $token)
    {
        $link = config('app.url') . '/register-by-token/' . $token;

        $mailModel = (new RegisterLinkModel())->setLink($link);

        Mail::to($email)->send(new RegisterLink($mailModel));
    }
}
