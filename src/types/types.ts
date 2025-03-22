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

export type APIParams = {
  page: number;
  results: number;
};

export type CreateOrderParams = {
  fullname: string; // Required
  pickup_address: string; // Required
  delivery_address: string; // Required
  item_description: string; // Required
  status?: string; // Optional, default 'Pending'
  customer_phone: string; // Required
  customer_email: string; // Optional
  delivery_type?: string; // Optional, default 'Standard'
  delivery_time_slot?: string; // Optional
  distance?: number; // Optional
  estimated_delivery_time?: string; // Optional (timestamp)
  actual_delivery_time?: string; // Optional (timestamp)
  package_weight?: number; // Optional
  package_dimensions?: string; // Optional
  is_fragile?: boolean; // Optional, default false
  special_instructions?: string; // Optional
  payment_status?: string; // Optional, default 'Unpaid'
  payment_method?: string; // Optional
  total_cost: number; // Required
  discount?: number; // Optional, default 0
  rider_id: number; // Required
  rider_notes?: string; // Optional
  admin_id: number; // Required
  user_id: number; // Required
  pickup_time?: string; // Optional (timestamp)
  delivery_attempts?: number; // Optional, default 0
  failed_delivery_reason?: string; // Optional
  order_source?: string; // Optional, default 'Website'
  order_priority?: number; // Optional, default 'Medium'
  cancellation_reason?: string; // Optional
  scheduled_pickup_time?: string; // Optional (timestamp)
  scheduled_delivery_time?: string; // Optional (timestamp)
  cancelled_at?: string; // Optional (timestamp)
};

export interface GeocoderResult {
  result: {
    place_name: string;
    geometry: {
      coordinates: [number, number];
    };
  };
}
