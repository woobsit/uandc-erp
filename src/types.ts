export interface Order {
  id: number;
  fullname: string;
  customer_phone: string;
  pickup_time: string;
  pickup_address: string;
  delivery_address: string;
  delivery_type: string;
  status: string;
  payment_status: string;
  total_cost: number;
  discount: number;
  delivery_time_slot: string;
  distance: string;
  estimated_delivery_time: string;
  actual_delivery_time: string;
  created_at: string;
}
