<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-typography-title :level="3">Create New Order</a-typography-title>
          <a-form
            :model="formState"
            @finish="onFinish"
            :label-col="labelCol"
            :wrapper-col="wrapperCol"
          >
            <div class="order-container">
              <a-form-item
                name="fullname"
                label="Fullname"
                :rules="[
                  { required: true, message: 'Please enter full name!' },
                  {
                    min: 3,
                    message: 'Full name must be at least 3 characters!',
                  },
                  {
                    max: 25,
                    message: 'Full name cannot exceed 25 characters!',
                  },
                ]"
              >
                <a-input v-model:value="formState.fullname">
                  <template #prefix
                    ><UserOutlined
                      style="color: rgba(0, 0, 0, 0.25)" /></template
                ></a-input>
              </a-form-item>
              <a-form-item
                name="customer_phone"
                label="Phone"
                :rules="[
                  { required: true, message: 'Please enter phone number!' },
                  {
                    pattern: /^[0-9]{10,15}$/,
                    message: 'Please enter a valid phone number!',
                  },
                ]"
              >
                <a-input v-model:value="formState.customer_phone">
                  <template #prefix
                    ><PhoneOutlined style="color: rgba(0, 0, 0, 0.25)"
                  /></template>
                </a-input>
              </a-form-item>
              <a-form-item
                name="customer_email"
                label="Email"
                :rules="[
                  { required: true, message: 'Please enter email address!' },
                  {
                    type: 'email',
                    message: 'Please enter a valid email address!',
                  },
                ]"
              >
                <a-input v-model:value="formState.customer_email">
                  <template #prefix
                    ><MailOutlined style="color: rgba(0, 0, 0, 0.25)"
                  /></template>
                </a-input>
              </a-form-item>
              <a-form-item
                name="pickup_address"
                label="Pickup Address"
                :rules="[
                  { required: true, message: 'Please enter pickup address!' },
                ]"
              >
                <div id="pickup_address">
                  <input type="text" />
                  <div
                    class="mapboxgl-ctrl mapboxgl-ctrl-geocoder mapboxgl-ctrl-geocoder--suggestion"
                  >
                    <!-- Suggestions should appear here -->
                  </div>
                </div>
              </a-form-item>
              <a-form-item
                name="delivery_address"
                label="Delivery Address"
                :rules="[
                  { required: true, message: 'Please enter delivery address!' },
                ]"
              >
                <div id="delivery_address">
                  <input type="text" />
                  <div
                    class="mapboxgl-ctrl mapboxgl-ctrl-geocoder mapboxgl-ctrl-geocoder--suggestion"
                  >
                    <!-- Suggestions should appear here -->
                  </div>
                </div>
              </a-form-item>
              <a-form-item name="item_description" label="Item Description">
                <a-textarea
                  v-model:value="formState.item_description"
                  :maxlength="1000"
                  show-count
                />
              </a-form-item>
              <a-form-item name="status" label="Status">
                <a-select v-model:value="formState.status">
                  <a-select-option value="Pending">Pending</a-select-option>
                  <a-select-option value="Processing"
                    >Processing</a-select-option
                  >
                  <a-select-option value="Completed">Completed</a-select-option>
                  <a-select-option value="Cancelled">Cancelled</a-select-option>
                </a-select>
              </a-form-item>

              <a-form-item name="delivery_type" label="Delivery type">
                <a-select v-model:value="formState.delivery_type">
                  <a-select-option value="Standard">Standard</a-select-option>
                  <a-select-option value="Express">Express</a-select-option>
                  <a-select-option value="Same Day">Same Day</a-select-option>
                  <a-select-option value="Overnight">Overnight</a-select-option>
                </a-select>
              </a-form-item>
              <a-form-item
                name="total_cost"
                label="Total Cost"
                :rules="[
                  { required: true, message: 'Please enter total cost!' },
                  {
                    validator: validateTotalCost,
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.total_cost"
                  :formatter="formatPrice"
                  :parser="parsePrice"
                />
              </a-form-item>
              <a-form-item
                name="discount"
                label="Discount"
                :rules="[
                  {
                    validator: validateDiscount,
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.discount"
                  :formatter="formatPrice"
                  :parser="parsePrice"
                />
              </a-form-item>
              <a-form-item name="payment_method" label="Payment method">
                <a-select v-model:value="formState.payment_method"
                  ><a-select-option value="Cash">Cash</a-select-option>
                  <a-select-option value="Transfer">Transfer</a-select-option>
                </a-select>
              </a-form-item>

              <a-typography-title :level="4">Extra Info</a-typography-title>
              <a-form-item
                label="Time slot"
                name="delivery_time_slot"
                v-bind="rangeConfig"
              >
                <a-range-picker
                  v-model:value="formState['cancelled_at']"
                  show-time
                  format="YYYY-MM-DD HH:mm:ss"
                  value-format="YYYY-MM-DD HH:mm:ss"
                />
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

              <a-form-item
                label="Package weight"
                name="package_weight"
                :rules="[
                  {
                    validator: validatePackageWeight,
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.package_weight"
                  :formatter="formatWeight"
                  :parser="parseWeight"
                />
              </a-form-item>

              <a-form-item label="Package dimensions" name="package_dimensions">
                <a-input v-model:value="formState.package_dimensions" />
              </a-form-item>
              <a-form-item label="Is fragile?" name="is_fragile">
                <a-switch v-model:checked="formState.is_fragile" />
              </a-form-item>

              <a-form-item
                name="special_instructions"
                label="Special instructions"
              >
                <a-textarea
                  v-model:value="formState.special_instructions"
                  :maxlength="1000"
                  show-count
                />
                <div
                  :style="{
                    color:
                      formState.special_instructions.length > 1000
                        ? 'red'
                        : 'inherit',
                  }"
                >
                  {{ formState.special_instructions.length }}/1000
                </div>
              </a-form-item>

              <a-form-item label="Payment status" name="payment_status">
                <a-select
                  v-model:value="formState.payment_status"
                  placeholder="Payment status"
                >
                  <a-select-option value="Unpaid">Unpaid</a-select-option>
                  <a-select-option value="Paid">Paid</a-select-option>
                  <a-select-option value="Cancelled">Cancelled</a-select-option>
                </a-select>
              </a-form-item>
              <a-form-item name="rider_notes" label="Riders notes">
                <a-textarea
                  v-model:value="formState.rider_notes"
                  :maxlength="1000"
                  show-count
                />
                <div
                  :style="{
                    color:
                      formState.rider_notes.length > 1000 ? 'red' : 'inherit',
                  }"
                >
                  {{ formState.rider_notes.length }}/1000
                </div>
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
                <a-textarea v-model:value="formState.failed_delivery_reason" />
              </a-form-item>

              <a-form-item label="Order source" name="order_source">
                <a-select
                  v-model:value="formState.order_source"
                  placeholder="Order source"
                >
                  <a-select-option value="Website">Website</a-select-option>
                  <a-select-option value="Social Media"
                    >Social Media</a-select-option
                  >
                  <a-select-option value="Flyers">Flyers</a-select-option>
                </a-select>
              </a-form-item>

              <a-form-item label="Order priority" name="order_priority">
                <a-radio-group v-model:value="formState.order_priority">
                  <a-radio value="1">Low</a-radio>
                  <a-radio value="2" checked>Medium</a-radio>
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
import { GeocoderResult } from '@/types/types';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import 'mapbox-gl/dist/mapbox-gl.css';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';
import {
  UserOutlined,
  PhoneOutlined,
  MailOutlined,
} from '@ant-design/icons-vue';

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
  order_priority: 2,
  cancellation_reason: '',
  scheduled_pickup_time: '',
  scheduled_delivery_time: '',
  cancelled_at: '',
  total_cost: 0,
  payment_method: 'Cash',
  rider_id: 1,
});

const labelCol = { style: { width: '150px' } };
const wrapperCol = { span: 14 };

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

// Price formatting
const formatPrice = (value: number) =>
  `₦${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
const parsePrice = (value: string) => value.replace(/₦\s?|(,*)/g, '');

// Weight formatting
const formatWeight = (value: number) => `${value} kg`;
const parseWeight = (value: string) => value.replace(/ kg/g, '');

// Validators
const validateTotalCost = async (_rule: any, value: number) => {
  if (isNaN(value)) {
    return Promise.reject('Please enter a valid number!');
  }
  return Promise.resolve();
};

const validateDiscount = async (_rule: any, value: number) => {
  if (isNaN(value)) {
    return Promise.reject('Please enter a valid number!');
  }
  if (value > formState.value.total_cost) {
    return Promise.reject('Discount cannot be greater than total cost!');
  }
  return Promise.resolve();
};

const validatePackageWeight = async (_rule: any, value: number) => {
  if (isNaN(value)) {
    return Promise.reject('Please enter a valid number!');
  }
  return Promise.resolve();
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
