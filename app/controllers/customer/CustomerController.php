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
        $items = Inventory::recent('created_at', 'DESC', 1000);

        $categories = [
            'Power Tools',
            'Hand Tools',
            'Construction Materials',
            'Locks and Security',
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

    /**
     * Filter inventory items by category and render the customer view
     */
    public function categoryFilter($category)
    {
        $decodedCategory = urldecode($category);

        $items = Inventory::whereMany(['category' => $decodedCategory]);

        $categories = [
            'Power Tools',
            'Hand Tools',
            'Construction Materials',
            'Locks and Security',
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
            'contact_number' => 'required|min:11|max:11',
            'address' => 'required',
            'current_password' => 'nullable',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|match:password',
            'profile_picture' => 'nullable'
        ]);

        // Only check current password if user wants to change password
        if (!empty($data['password'])) {
            if (empty($data['current_password'])) {
                setSweetAlert('error', 'Validation Error', 'Current password is required to set a new password.');
                redirect('/customer/edit-profile');
            }

            // Check if current password matches
            if (!password_verify($data['current_password'], $user->password)) {
                setSweetAlert('error', 'Invalid Password', 'Your current password is incorrect.');
                redirect('/customer/edit-profile');
            }

            // Replace with hashed new password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        // Remove fields we don't need to store
        unset($data['current_password'], $data['password_confirmation'], $data['_token']);

        // Handle profile picture upload and replace old one if exists
        $profile = FileHandler::fromRequest('profile_picture');
        if ($profile) {
            if (!empty($user->profile_picture)) {
                FileHandler::delete('public/storage/profile-img/', $user->profile_picture);
            }
            $data['profile_picture'] = $profile->store('public/storage/profile-img');
        } else {
            // Keep existing profile picture, don't include in change detection
            unset($data['profile_picture']);
        }

        // Check if there are actual changes to make
        $hasChanges = false;
        
        foreach ($data as $key => $value) {
            // Convert both values to strings for comparison and trim whitespace
            $currentValue = trim((string)($user->$key ?? ''));
            $newValue = trim((string)$value);
            
            if ($currentValue !== $newValue) {
                $hasChanges = true;
                break;
            }
        }

        if (!$hasChanges) {
            setSweetAlert('info', 'No Changes', 'No changes were made to your profile.');
            redirect('/customer/edit-profile');
        }

        // Add back profile picture if it was uploaded
        if ($profile) {
            $data['profile_picture'] = $profile->store('public/storage/profile-img');
        }

        if (User::update($user->id, $data)) {
            setSweetAlert('success', 'Updated!', 'Profile info has been updated.');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn\'t update your profile.');
        }

        redirect('/customer/profile');
    }

    /**
     * Display the order history of the logged-in customer.
     */
    public function orders()
    {
        $orders = Orders::recentWhere(['user_id' => auth()->id], 'created_at', 'DESC', 100);

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
