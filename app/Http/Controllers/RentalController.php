<?php

namespace App\Http\Controllers;

use App\Mail\RentalNotification;
use App\Mail\RentalNotificationRequest;
use App\Http\Requests;
use App\Rental;
use App\User;
use App\RentalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RentalOption;
use App\Notifications\RentalConfirmed; 


use Illuminate\Support\Facades\Mail;

/**
 * Class RentalController
 *
 * @package   App\Http\Controllers
 * @author    Tim Joosten <Topairy@gmail.com>
 * @copyright Tim Joosten 2015 - 2016
 * @version   2.0.0
 */
class RentalController extends Controller
{
    /**
     * Authencation middleware protected routes.
     * @var mixed
     */
    protected $authMiddleware;

    /**
     * RentalController constructor.
     */
    public function __construct()
    {
        $this->authMiddleware = [
            'indexBackEnd', 'setOption', 'setConfirmed', 'destroy'
        ];

        // Middleware
        $this->middleware('lang');
        $this->middleware('auth')->only($this->authMiddleware);
    }

    /**
     * [BACK-END]: The backend side for the rental module.
     *
     * @url:platform  GET|HEAD: /backend/rental
     * @see:phpunit   RentalTest::
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexBackEnd()
    {
        $data['rentals'] = Rental::with('status')->paginate(25);
        return view('rental.backend-overview', $data);
    }

    /**
     * [FRONT-END]: front-end overview with the domain description.
     *
     * @url:platform  GET|HEAD: /rental
     * @see:phpunit   RentalTest::testFrontendOverView()
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFrontEnd()
    {
        return view('rental.frontend-overview');
    }

    /**
     * [FRONT-END]: Front-end view for the rental Calendar
     *
     * @url:platform  GET|HEAD: /rental/calendar
     * @see:phpunit   RentalTest::testRentalCalendar()
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendar()
    {
        $data['items'] = Rental::whereHas('status', function ($query) {
            $query->where('name', 'Bevestigd');
        })->get();

        return view('rental.frontend-calendar', $data);
    }

    /**
     * [METHOD]: Set a rental status to 'Option'.
     *
     * @url:platform
     * @see:phpunit
     *
     * @param  int $id the rental id in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setOption($id)
    {
        if (Rental::find($id)->update(['status_id' => 1])) {
            session()->flash('class', 'alert alert-success');
            session()->flash('message', '');
        }

        return redirect()->back();
    }

    /**
     * [METHOD]: Set a rental status to 'confirmed'.
     *
     * @url:platform
     * @see:phpunit
     *
     * @param  int $id the rental id in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setConfirmed($id)
    {
        if (Rental::find($id)->update(['status_id' => 2])) {
            session()->flash('class', 'alert alert-success');
            session()->flash('message', '');

            // Notification
            Notification::send(User::all(), new RentalConfirmed());
        }

        return redirect()->back();
    }

    /**
     * [FRONT-END]: Front-end insert view fcr the rental view.
     *
     * @url:platform  GET|HEAD: /rental/insert
     * @see:phpunit   RentalTest::testRentalInsertFormFrontEnd()
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insertViewFrontEnd()
    {
        return view('rental.frontend-insert');
    }

    /**
     * [METHOD]: Insert method for the rental module.
     *
     * @url:platform  POST: /rental/insert
	 * @see:phpunit	  RentalTest::testRentalInsertErrors()
	 * @see:phpunit   RentalTest::testRentalInsertSuccess()
     *
     * @param  Requests\RentalValidator $input
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Requests\RentalValidator $input)
    {
        $insert = Rental::create($input->except('_token'));
        $status = RentalStatus::find(3);

        Rental::find($insert->id)->update(['status_id' => $status->id]);

        if ($insert) {
            session()->flash('class', 'alert alert-success');
            session()->flash('message', '');

            if (! auth()->check()) {
                $rental = Rental::find($insert->id);

                // Trigger mailable error for now. because there is no one with the role.

                // TODO: Write patch with standard platform config variable.
                $logins = User::with('permissions')->whereIn('name', ['rental']);

                Mail::to($insert)->queue(new RentalNotificationRequest($rental));
                Mail::to($logins)->queue(new RentalNotification($rental));
            } elseif (auth()->check()) {
                Notification::send(Users::all(), new RentalInsertNotification());
            }
        }

        return redirect()->back();
    }

    /**
     * [BACK-END]: Update view for the rental module.
     *
     * @url:platform  GET|HEAD:
	 * @see:phpunit   RentalTest::testRentalUpdateView()
     *
     * @param  int $id the rental id in the database.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
		$data['rental'] = Rental::find($id);
	    return view('', $data);
    }

    /**
     * [METHOD]: Update the rental in the module.
     *
     * @url:platform  PUT|PATCH:
	 * @see:phpunit   RentalTest::testRentalUpdateWithoutSuccess()
	 * @see:phpunit   RentalTest::testRentalUpdateWithSuccess()
     *
     * @param  Requests\RentalValidator $input
     * @param  int $id the rental id in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Requests\RentalValidator $input, $id)
    {
        $rental = Rental::find($id);
        $rental->input($input->except('_token'));

        session()->flash('class', 'alert alert-success');
        session()->flash('message', '');

        return redirect()->back();
    }

    /**
     * [METHOD]: Delete method for the rental method.
     *
     * @url:platform:  GET|HEAD: /rental/destroy/{id}
	 * @see:phpunit    RentalTest::testRentalDelete()
	 *
     * @param  int $id the rental id in the database
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $delete = Rental::destroy($id);

        if ($delete) {
            session()->flash('class', 'alert alert-success');
            session()->flash('message', '');
        }

        return redirect()->back();
    }
}
