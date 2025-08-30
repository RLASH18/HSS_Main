<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\core\FileHandler;
use app\core\Request;
use app\models\Inventory;
use app\models\User;
use app\models\Orders;

class CustomerController extends Controller
{
    /**
     * Display the customer dashboard with all available inventory items.
     */
    public function index()
    {
        $items = Inventory::all();

        $categories = [
            'Power Tools',
            'Hand Tools',
            'Construction Materials',
            'Lock and Security',
            'Plumbing',
            'Electrical',
            'Paint and Finishes',
            'Chemicals'
        ];

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | Customer Dashboard',
            'items' => $items,
            'categories' => $categories,
            'selectedCategory' => null,
        ];

        return $this->view('customer/index', $data);
    }

    public function categoryFilter($category)
    {
        $decodedCategory = urldecode($category);

        $items = Inventory::whereMany(['category' => $decodedCategory]);

        $categories = [
            'Power Tools',
            'Hand Tools',
            'Construction Materials',
            'Lock and Security',
            'Plumbing',
            'Electrical',
            'Paint and Finishes',
            'Chemicals'
        ];

        $data = [
            'title' => "ABG Prime Builders Supplies Inc. | Category: $decodedCategory",
            'items' => $items,
            'categories' => $categories,
            'selectedCategory' => $decodedCategory
        ];

        return $this->view('customer/index', $data);
    }

    /**
     * Display details of a specific inventory item by ID.
     */
    public function show($id)
    {
        $items = Inventory::find($id);

        if (!$items) {
            setSweetAlert('error', 'Oops!', 'Item not found.');
            redirect('/customer/home');
        }

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | ' . $items->item_name,
            'items' => $items,
        ];

        return $this->view('customer/show', $data);
    }

    /**
     * Display the logged-in customer's profile information.
     */
    public function profile()
    {
        $users = User::where(['id' => auth()->id]);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | My Profile',
            'users' => $users,
        ];

        return $this->view('customer/profile/index', $data);
    }

    /**
     * Display the Edit Profile page with the current user's data
     */
    public function editProfile()
    {
        $users = User::where(['id' => auth()->id]);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | Edit Profile',
            'users' => $users,
        ];

        return $this->view('customer/profile/update', $data);
    }

    /**
     * Handle profile update request and save changes
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(auth()->id);

        if (!$user || $user->id !== auth()->id) {
            setSweetAlert('error', 'Error', 'User not found.');
            redirect('/');
        }

        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . auth()->id,
            'email' => 'required|email|unique:users,email,' . auth()->id,
            'birthdate' => 'nullable',
            'gender' => 'nullable',
            'contact_number' => 'required',
            'address' => 'required',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'match:password',
            'profile_picture' => 'nullable'
        ]);

        // Remove password_confirmation from data before database update
        unset($data['password_confirmation']);

        // Hash new password if provided, otherwise ignore
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        // Handle profile picture upload and replace old one if exists
        $profile = FileHandler::fromRequest('profile_picture');
        if ($profile) {
            if (!empty($user->profile_picture)) {
                FileHandler::delete('public/storage/profile-img/', $user->profile_picture);
            }
            $data['profile_picture'] = $profile->store('public/storage/profile-img');
        } else {
            $data['profile_picture'] = $user->profile_picture;
        }

        if (User::update($user->id, $data)) {
            setSweetAlert('success', 'Updated!', 'Profile info has been updated.');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn’t update the your profile.');
        }

        redirect('/customer/profile');
    }

    /**
     * Display the order history of the logged-in customer.
     */
    public function orders()
    {
        $orders = Orders::whereMany(['user_id' => auth()->id]);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | My Orders',
            'orders' => $orders
        ];

        return $this->view('customer/orders', $data);
    }

    /**
     * Log out the current customer and redirect to the homepage.
     */
    public function logout()
    {
        logout();
        return redirect('/');
    }
}
