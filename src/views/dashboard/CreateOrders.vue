<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-typography-title :level="3">Create New Order</a-typography-title>
          <a-form :model="formState" @finish="onFinish">
            <a-form-item label="Full Name" name="full_name">
              <a-input v-model:value="formState.fullname" />
            </a-form-item>
            <a-form-item label="Pickup Address" name="pickup_address">
              <a-input
                v-model:value="formState.pickup_address"
                id="pickup_address"
              />
            </a-form-item>
            <a-form-item label="Delivery Address" name="delivery_address">
              <a-input
                v-model:value="formState.delivery_address"
                id="delivery_address"
              />
            </a-form-item>
            <a-form-item label="Item Description" name="item_description">
              <a-input v-model:value="formState.item_description" />
            </a-form-item>
            <a-form-item label="Status" name="status">
              <a-select v-model:value="formState.status">
                <a-select-option value="Pending">Pending</a-select-option>
                <a-select-option value="Processing">Processing</a-select-option>
                <a-select-option value="Completed">Completed</a-select-option>
                <a-select-option value="Cancelled">Cancelled</a-select-option>
              </a-select>
            </a-form-item>
            <a-form-item label="Customer Phone" name="customer_phone">
              <a-input v-model:value="formState.customer_phone" />
            </a-form-item>
            <a-form-item label="Customer Email" name="customer_email">
              <a-input v-model:value="formState.customer_email" />
            </a-form-item>
            <a-form-item label="Delivery Type" name="delivery_type">
              <a-input v-model:value="formState.delivery_type" />
            </a-form-item>
            <a-form-item label="Total Cost" name="total_cost">
              <a-input-number v-model:value="formState.total_cost" />
            </a-form-item>
            <a-form-item label="Payment Method" name="payment_method">
              <a-input v-model:value="formState.payment_method" />
            </a-form-item>
            <a-form-item label="Rider ID" name="rider_id">
              <a-input v-model:value="formState.rider_id" />
            </a-form-item>
            <a-form-item label="Distance" name="distance">
              <a-input
                v-model:value="formState.distance"
                disabled
                placeholder="Distance will be calculated automatically"
              />
            </a-form-item>
            <a-form-item>
              <a-button type="primary" html-type="submit">Submit</a-button>
            </a-form-item>
          </a-form>
        </div>
        <FooterTemplate />
      </a-layout>
    </a-layout>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import SideBar from '@/components/template/SidebarTemplate.vue';
import HeaderTemplate from '@/components/template/HeaderTemplate.vue';
import FooterTemplate from '@/components/template/FooterTemplate.vue';
import authService from '@/api/services';
import { GeocoderResult } from '@/types';
// @ts-ignore
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import 'mapbox-gl/dist/mapbox-gl.css';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';

// Define form state
const formState = ref({
  fullname: '',
  pickup_address: '',
  delivery_address: '',
  item_description: '',
  status: 'Pending',
  customer_phone: '',
  customer_email: '',
  delivery_type: 'Standard',
  delivery_time_slot: '',
  distance: 0,
  estimated_delivery_time: '',
  actual_delivery_time: '',
  package_weight: 0,
  package_dimensions: '',
  is_fragile: false,
  special_instructions: '',
  payment_status: 'Unpaid',
  discount: 0,
  rider_notes: '',
  admin_id: 1,
  user_id: 1,
  pickup_time: '',
  delivery_attempts: 0,
  failed_delivery_reason: '',
  order_source: 'Website',
  order_priority: 'Medium',
  cancellation_reason: '',
  scheduled_pickup_time: '',
  scheduled_delivery_time: '',
  cancelled_at: '',
  total_cost: 0,
  payment_method: '',
  rider_id: 1,
});

// Initialize Mapbox Geocoder for Autocomplete
onMounted(() => {
  const pickupInput = document.getElementById(
    'pickup_address'
  ) as HTMLInputElement;
  const deliveryInput = document.getElementById(
    'delivery_address'
  ) as HTMLInputElement;

  const pickupGeocoder = new MapboxGeocoder({
    accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN,
    types: 'address',
  });

  const deliveryGeocoder = new MapboxGeocoder({
    accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN,
    types: 'address',
  });

  // Attach Geocoder to input fields

  pickupGeocoder.addTo('#pickup_address');
  deliveryGeocoder.addTo('#delivery_address');

  // Update formState when an address is selected
  pickupGeocoder.on('result', (event: GeocoderResult) => {
    formState.value.pickup_address = event.result.place_name || '';
    calculateDistance();
  });

  deliveryGeocoder.on('result', (event: GeocoderResult) => {
    formState.value.delivery_address = event.result.place_name || '';
    calculateDistance();
  });
});

// Calculate distance between pickup and delivery addresses
const calculateDistance = async () => {
  const pickupAddress = formState.value.pickup_address;
  const deliveryAddress = formState.value.delivery_address;

  if (pickupAddress && deliveryAddress) {
    try {
      const distance = await getDistance(pickupAddress, deliveryAddress);
      formState.value.distance = distance;
    } catch (error) {
      console.error('Error calculating distance:', error);
      formState.value.distance = 0; // Reset distance on error
    }
  }
};

// Function to calculate distance using Mapbox Directions API
const getDistance = async (
  origin: string,
  destination: string
): Promise<number> => {
  const response = await fetch(
    `https://api.mapbox.com/directions/v5/mapbox/driving/${encodeURIComponent(
      origin
    )};${encodeURIComponent(destination)}?access_token=${process.env.VUE_APP_MAPBOX_ACCESS_TOKEN}`
  );
  const data = await response.json();
  if (data.routes && data.routes.length > 0) {
    return data.routes[0].distance / 1000; // Distance in kilometers
  } else {
    throw new Error('Distance calculation failed: No route found');
  }
};

// Handle form submission
const onFinish = async () => {
  try {
    const response = await authService.createOrder(formState.value);
    if (response.status === 201) {
      alert('Order created successfully!');
      // Optionally reset the form or redirect the user
    }
  } catch (error) {
    alert('Failed to create order');
    console.error(error);
  }
};
</script>
<style scoped>
.content-container {
  padding: 24px;
}
</style>
