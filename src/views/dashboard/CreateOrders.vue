<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-typography-title :level="3">Create New Order</a-typography-title>
          <a-form :model="formState" @finish="onFinish">
            <div class="order-container">
              <div class="order-container__upper-box">
                <a-form-item name="fullname">
                  <a-input
                    v-model:value="formState.fullname"
                    placeholder="Fullname"
                  />
                </a-form-item>
                <a-form-item name="customer_phone">
                  <a-input
                    v-model:value="formState.customer_phone"
                    placeholder="Customer Phone"
                  />
                </a-form-item>
                <a-form-item name="customer_email">
                  <a-input
                    v-model:value="formState.customer_email"
                    placeholder="Customer Email"
                  />
                </a-form-item>
                <a-form-item>
                  <div id="pickup_address">
                    <input type="text" />
                    <div
                      class="mapboxgl-ctrl mapboxgl-ctrl-geocoder mapboxgl-ctrl-geocoder--suggestion"
                    >
                      <!-- Suggestions should appear here -->
                    </div>
                  </div>
                </a-form-item>
                <a-form-item>
                  <div id="delivery_address">
                    <input type="text" />
                    <div
                      class="mapboxgl-ctrl mapboxgl-ctrl-geocoder mapboxgl-ctrl-geocoder--suggestion"
                    >
                      <!-- Suggestions should appear here -->
                    </div>
                  </div>
                </a-form-item>
                <a-form-item name="item_description">
                  <a-textarea
                    v-model:value="formState.item_description"
                    placeholder="Item Description"
                  />
                </a-form-item>
                <a-form-item name="status">
                  <a-select
                    v-model:value="formState.status"
                    placeholder="please select your zone"
                  >
                    <a-select-option value="Pending">Pending</a-select-option>
                    <a-select-option value="Processing"
                      >Processing</a-select-option
                    >
                    <a-select-option value="Completed"
                      >Completed</a-select-option
                    >
                    <a-select-option value="Cancelled"
                      >Cancelled</a-select-option
                    >
                  </a-select>
                </a-form-item>

                <a-form-item name="delivery_type">
                  <a-select
                    v-model:value="formState.delivery_type"
                    placeholder="please select delivery type"
                  >
                    <a-select-option value="Standard">Standard</a-select-option>
                    <a-select-option value="Express">Express</a-select-option>
                    <a-select-option value="Same Day">Same Day</a-select-option>
                    <a-select-option value="Overnight"
                      >Overnight</a-select-option
                    >
                  </a-select>
                </a-form-item>
                <a-form-item name="total_cost">
                  <a-input-number
                    v-model:value="formState.total_cost"
                    placeholder="Total Cost"
                  />
                </a-form-item>
                <a-form-item name="discount">
                  <a-input-number
                    v-model:value="formState.discount"
                    placeholder="Discount"
                  />
                </a-form-item>
                <a-form-item name="payment_method">
                  <a-select
                    v-model:value="formState.payment_method"
                    placeholder="Payment method"
                  >
                    <a-select-option value="Cash">Cash</a-select-option>
                    <a-select-option value="Transfer">Transfer</a-select-option>
                  </a-select>
                </a-form-item>
              </div>
              <div class="order-container__lower-box">
                <a-typography-title :level="4">Extra Info</a-typography-title>
                <a-form-item label="Time slot" name="delivery_time_slot">
                  <a-input v-model:value="formState.delivery_time_slot" />
                </a-form-item>
                <a-form-item label="Distance" name="distance">
                  <a-input
                    v-model:value="formState.distance"
                    placeholder="Distance will be calculated automatically"
                  />
                </a-form-item>

                <a-form-item
                  label="Estimated delivery time"
                  name="estimated_delivery_time"
                >
                  <a-input v-model:value="formState.estimated_delivery_time" />
                </a-form-item>

                <a-form-item
                  label="Actual delivery time"
                  name="actual_delivery_time"
                >
                  <a-input v-model:value="formState.actual_delivery_time" />
                </a-form-item>

                <a-form-item label="Package weight" name="package_weight">
                  <a-input v-model:value="formState.package_weight" />
                </a-form-item>

                <a-form-item
                  label="Package dimensions"
                  name="package_dimensions"
                >
                  <a-input v-model:value="formState.package_dimensions" />
                </a-form-item>
                <a-form-item label="Is fragile?" name="is_fragile">
                  <a-switch v-model:checked="formState.is_fragile" />
                </a-form-item>

                <a-form-item
                  name="special_instructions"
                  label="Special instructions"
                >
                  <a-textarea v-model:value="formState.special_instructions" />
                </a-form-item>

                <a-form-item label="Payment status" name="payment_status">
                  <a-select
                    v-model:value="formState.payment_status"
                    placeholder="Payment status"
                  >
                    <a-select-option value="Unpaid">Unpaid</a-select-option>
                    <a-select-option value="Paid">Paid</a-select-option>
                    <a-select-option value="Cancelled"
                      >Cancelled</a-select-option
                    >
                  </a-select>
                </a-form-item>
                <a-form-item name="rider_notes" label="Riders notes">
                  <a-textarea v-model:value="formState.rider_notes" />
                </a-form-item>

                <a-form-item
                  name="pickup_time"
                  label="Pickup time"
                  v-bind="rangeConfig"
                >
                  <a-range-picker
                    v-model:value="formState['pickup_time']"
                    show-time
                    format="YYYY-MM-DD HH:mm:ss"
                    value-format="YYYY-MM-DD HH:mm:ss"
                  />
                </a-form-item>

                <a-form-item label="Delivery attempts" name="delivery_attempts">
                  <a-input-number v-model:value="formState.delivery_attempts" />
                </a-form-item>

                <a-form-item
                  name="failed_delivery_reason"
                  label="Failed delivery reason"
                >
                  <a-textarea
                    v-model:value="formState.failed_delivery_reason"
                  />
                </a-form-item>

                <a-form-item label="Order source" name="order_source">
                  <a-select
                    v-model:value="formState.order_source"
                    placeholder="Order source"
                  >
                    <a-select-option value="Internet">Internet</a-select-option>
                  </a-select>
                </a-form-item>

                <a-form-item label="Order priority" name="order_priority">
                  <a-radio-group v-model:value="formState.order_priority">
                    <a-radio value="1">Low</a-radio>
                    <a-radio value="2">Medium</a-radio>
                    <a-radio value="3">High</a-radio>
                  </a-radio-group>
                </a-form-item>

                <a-form-item
                  name="cancellation_reason"
                  label="Cancellation reason"
                >
                  <a-textarea v-model:value="formState.cancellation_reason" />
                </a-form-item>

                <a-form-item
                  name="scheduled_pickup_time"
                  label="Scheduled pickup time"
                  v-bind="rangeConfig"
                >
                  <a-range-picker
                    v-model:value="formState['scheduled_pickup_time']"
                    show-time
                    format="YYYY-MM-DD HH:mm:ss"
                    value-format="YYYY-MM-DD HH:mm:ss"
                  />
                </a-form-item>

                <a-form-item
                  name="scheduled_delivery_time"
                  label="Scheduled delivery time"
                  v-bind="rangeConfig"
                >
                  <a-range-picker
                    v-model:value="formState['scheduled_delivery_time']"
                    show-time
                    format="YYYY-MM-DD HH:mm:ss"
                    value-format="YYYY-MM-DD HH:mm:ss"
                  />
                </a-form-item>

                <a-form-item
                  name="cancelled_at"
                  label="Cancelled at"
                  v-bind="rangeConfig"
                >
                  <a-range-picker
                    v-model:value="formState['cancelled_at']"
                    show-time
                    format="YYYY-MM-DD HH:mm:ss"
                    value-format="YYYY-MM-DD HH:mm:ss"
                  />
                </a-form-item>
              </div>
              <a-form-item>
                <a-button type="primary" html-type="submit">Submit</a-button>
              </a-form-item>
            </div>
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

const rangeConfig = {
  rules: [
    { type: 'array' as const, required: true, message: 'Please select time!' },
  ],
};

// Initialize Mapbox Geocoder for Autocomplete
onMounted(() => {
  const pickupGeocoder = new MapboxGeocoder({
    accessToken:
      'pk.eyJ1Ijoid29vYnNpdCIsImEiOiJjbThmdDE5d3Qwa2IyMmtzZDdlMjA2ZjA0In0.sJjalkK3ent1d8pFGob_oQ',
    types: 'address',
    placeholder: 'Enter pickup address',
  });

  const deliveryGeocoder = new MapboxGeocoder({
    accessToken:
      'pk.eyJ1Ijoid29vYnNpdCIsImEiOiJjbThmdDE5d3Qwa2IyMmtzZDdlMjA2ZjA0In0.sJjalkK3ent1d8pFGob_oQ',
    types: 'address',
    placeholder: 'Enter delivery address',
  });

  // Attach Geocoder to input fields
  const pickupInput = document.getElementById('pickup_address');
  const deliveryInput = document.getElementById('delivery_address');

  if (pickupInput) {
    pickupGeocoder.addTo('#pickup_address');
  } else {
    console.error('Pickup address input field not found');
  }

  if (deliveryInput) {
    deliveryGeocoder.addTo('#delivery_address');
  } else {
    console.error('Delivery address input field not found');
  }

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
    )};${encodeURIComponent(destination)}?access_token=pk.eyJ1Ijoid29vYnNpdCIsImEiOiJjbThmdDE5d3Qwa2IyMmtzZDdlMjA2ZjA0In0.sJjalkK3ent1d8pFGob_oQ`
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
