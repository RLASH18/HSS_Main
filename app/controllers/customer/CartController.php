<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Cart;
use app\models\Inventory;

class CartController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->id;
    }

    /**
     * Display all cart items for the logged-in user.
     */
    public function index()
    {
        // Get all cart items that belong to the current user
        $carts = Cart::whereMany(['user_id' => $this->userId]);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | My Cart',
            'carts' => $carts
        ];

        return $this->view('customer/cart', $data);
    }

    /**
     * Store a new item in the user's cart.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|min:1'
        ]);

        // Ensure requested quantity is in stock, else show error and redirect
        $item = Inventory::find($data['item_id']);
        if (!$item || $data['quantity'] > $item->quantity) {
            setSweetAlert('error', 'Oops!', "Only {$item->quantity} items available in stock.");
            redirect('/customer/show/' . $data['item_id']);
        }

        // Check if this item already exists in the user's cart
        $existingCart = Cart::whereMany([
            'user_id' => $this->userId,
            'item_id' => $data['item_id']
        ], true);

        if ($existingCart) {
            // If exists, update quantity
            $newQty = $existingCart->quantity + $data['quantity'];

            // Ensure it doesn't exceed stock
            if ($newQty > $item->quantity) {
                $newQty = $item->quantity;
            }

            Cart::update($existingCart->id, ['quantity' => $newQty]);
        } else {
            Cart::insert([
                'user_id' => $this->userId,
                'item_id' => $data['item_id'],
                'quantity' => $data['quantity'],
            ]);
        }
        setSweetAlert('success', 'Added!', 'Item added to cart successfully.');
        redirect('/customer/my-cart');
    }

    /**
     * Update an existing cart item.
     */
    public function update(Request $request, Response $response)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required|min:1'
        ]);

        $carts = $this->findCartOrFail($data['id']);

        // Ensure the user owns the cart before updating
        if ($carts->user_id !== $this->userId) {
            $response->setStatusCode(403);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit;
        }

        // Ensure requested quantity does not exceed available stock
        if ($data['quantity'] > $carts->item->quantity) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => "Sorry, only {$carts->item->quantity} items available in stock."
            ]);
            exit;
        }

        Cart::update($carts->id, ['quantity' => $data['quantity']]);
        $itemTotal = $carts->item->unit_price * $data['quantity'];

        // Return updated item total in JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'itemTotal' => $itemTotal]);
        exit;
    }

    /**
     * Delete a cart item by ID.
     */
    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $id = $data['id'];

        $carts = $this->findCartOrFail($id);

        // Ensures ownership before removing the item from the cart.
        if ($carts->user_id !== $this->userId) {
            setSweetAlert('error', 'Unauthorized!', 'You cannot delete this cart item.');
            redirect('/customer/my-cart');
        }

        Cart::delete($carts->id);
        setSweetAlert('success', 'Removed!', 'Item removed from cart.');
        redirect('/customer/my-cart');
    }

    /**
     * Find a cart item by ID or fail.
     */
    private function findCartOrFail($id)
    {
        $carts = Cart::find($id);

        if (!$carts) {
            // Check if this is an AJAX request
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Cart not found.'
                ]);
                exit;
            }

            setSweetAlert('error', 'Oops!', 'Cart not found.');
            redirect('/customer/cart');
        }

        return $carts;
    }
}
