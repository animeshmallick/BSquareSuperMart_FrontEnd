<?php
class Common {
    public function is_user_logged_in($customer_id): bool
    {
        return $customer_id !== null && strlen($customer_id) > 0;
    }
}
