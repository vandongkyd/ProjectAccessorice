<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:admin');
        $this->userService = $userService;
    }

    /**
     * @return View: Admin.User.List
     */
    public function index(){

        $users = $this->userService->list();
        return view('admin.user.index',[
            'users' => $users
        ]);
    }

    /**
     * @return View: Admin.User.Add
     */
    public function add(){

        $shops = $this->getShop();
        return view('admin.user.add',[
            'shops' => $shops
        ]);
    }


    /**
     * @action Add record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doAdd(Request $req){

        try {
            $user = $this->userService->add($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($user['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.User.Edit
     */
    public function edit($id){

        $user = $this->userService->fetchById($id);
        $shops = $this->getShop();

        return view('admin.user.edit',[
            'user' => $user,
            'shops' => $shops
        ]);
    }

    /**
     * @action Edit record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doEdit(Request $req){

        try {
            $user = $this->userService->edit($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($user['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }


    /**
     * @action Delete record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doDelete(Request $req){

        try {
            $user = $this->userService->delete($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Unlock record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doUnlock(Request $req){

        try {
            $user = $this->userService->unlock($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.unlock'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.unlock'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Lock record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doLock(Request $req){

        try {
            $user = $this->userService->lock($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.lock'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.lock'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Reset record User
     * @param Request $req
     * @return View: Admin.User.List
     */
    public function doReset(Request $req){

        try {
            $user = $this->userService->reset($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.reset'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->route('user.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.reset'),'name' => Lang::get('messages.lbl_screen_menu.user')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Change Language record User
     * @param Request $req
     * @return View: Back screen current
     */
    public function doChangeLanguage(Request $req){

        try {
            $user = $this->userService->changeLanguage($req);
            if($user['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.change'),'name' => Lang::get('messages.lbl_languages')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.change'),'name' => Lang::get('messages.lbl_languages')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
