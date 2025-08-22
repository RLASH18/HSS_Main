<?php

namespace app\controllers\customer;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Cart;

class CartController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->id;
    }

    public function index()
    {
        $carts = Cart::whereMany(['user_id' => $this->userId]);

        $data = [
            'title' => 'ABG Prime Builders Supplies Inc. | My Cart',
            'carts' => $carts
        ];

        return $this->view('customer/cart', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|min:1'
        ]);

        Cart::insert([
            'user_id' => $this->userId,
            'item_id' => $data['item_id'],
            'quantity' => $data['quantity'],
        ]);
        setSweetAlert('success', 'Added!', 'Item added to cart successfully.');
        redirect('/customer/my-cart');
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required|min:1'
        ]);

        $carts = $this->findCartOrFail($data['id']);

        if ($carts->user_id !== $this->userId) {
            $response->setStatusCode(403);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit;
        }

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

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'itemTotal' => $itemTotal]);
        exit;
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $id = $data['id'];

        $carts = $this->findCartOrFail($id);

        if ($carts->user_id !== $this->userId) {
            setSweetAlert('error', 'Unauthorized!', 'You cannot delete this cart item.');
            redirect('/customer/my-cart');
        }

        Cart::delete($carts->id);
        setSweetAlert('success', 'Removed!', 'Item removed from cart.');
        redirect('/customer/my-cart');
    }

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
