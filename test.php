<?php
require_once 'bootstrap/app.php';

use app\models\User;
use app\core\Request;

// Test the actual profile update process
echo "Testing profile update process...\n\n";

try {
    // Start session properly
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Simulate being logged in as user ID 2
    $_SESSION['user_id'] = 2;
    
    // Manually set the user in the Application (since auth() uses Application::$app->user)
    $testUser = User::find(2);
    if ($testUser) {
        \app\core\Application::$app->user = $testUser;
        echo "✓ Manually set authenticated user: " . $testUser->name . " (ID: " . $testUser->id . ")\n";
    } else {
        echo "✗ Could not find user with ID 2\n";
        exit;
    }
    
    // Test auth() function
    $authUser = auth();
    if ($authUser) {
        echo "✓ Authentication working: User ID " . $authUser->id . "\n";
    } else {
        echo "✗ Authentication still failed\n";
        exit;
    }
    
    // Simulate form data (like what would come from the form)
    $_POST = [
        'name' => 'Ryan Lester Lacdang Updated',
        'username' => 'ryan',
        'email' => 'lacdangryan13@gmail.com',
        'birthdate' => '1990-01-01',
        'gender' => 'male',
        'contact_number' => '09123456789',
        'address' => 'Updated Test Address',
        'password' => '', // Empty password
        'password_confirmation' => ''
    ];
    
    echo "✓ Simulated form data:\n";
    print_r($_POST);
    echo "\n";
    
    // Test the Request validation
    $request = new Request();
    
    echo "Testing validation...\n";
    try {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . auth()->id,
            'email' => 'required|email|unique:users,email,' . auth()->id,
            'birthdate' => 'nullable',
            'gender' => 'nullable',
            'contact_number' => 'required',
            'address' => 'required',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable',
            'profile_picture' => 'nullable'
        ]);
        
        echo "✓ Validation passed!\n";
        echo "Validated data:\n";
        print_r($data);
        echo "\n";
        
        // Remove password_confirmation
        unset($data['password_confirmation']);
        
        // Handle empty password
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        echo "Final data for update:\n";
        print_r($data);
        echo "\n";
        
        // Test the actual update
        $user = User::find(auth()->id);
        $result = User::update($user->id, $data);
        
        if ($result) {
            echo "✓ Profile update successful!\n";
            
            // Verify the update
            $updatedUser = User::find(auth()->id);
            echo "Updated user data:\n";
            echo "- Name: " . $updatedUser->name . "\n";
            echo "- Address: " . $updatedUser->address . "\n";
            echo "- Contact: " . $updatedUser->contact_number . "\n";
        } else {
            echo "✗ Profile update failed!\n";
            
            $pdo = \app\core\Application::$app->db->pdo;
            $errorInfo = $pdo->errorInfo();
            echo "PDO Error: " . print_r($errorInfo, true) . "\n";
        }
        
    } catch (Exception $e) {
        echo "✗ Validation failed: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Test session and auth helpers
echo "\n--- Session & Auth Test ---\n";
echo "Session ID: " . session_id() . "\n";
echo "User ID in session: " . ($_SESSION['user_id'] ?? 'not set') . "\n";
echo "auth() function returns: " . (auth() ? auth()->name : 'null') . "\n";
echo "auth()->id returns: " . (auth() ? auth()->id : 'null') . "\n";

// Test what happens in actual web request
echo "\n--- Debugging Real Issue ---\n";
echo "The issue might be that when you submit the form:\n";
echo "1. The form data is not being received properly\n";
echo "2. Validation is failing silently\n";
echo "3. Authentication is not working in web context\n";
echo "4. Redirect happens before update completes\n";
echo "\nNext step: Add the debugging code to your CustomerController and try the form again.\n";
?>
