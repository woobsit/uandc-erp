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
                name="sender_fullname"
                label="Sender fullname"
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
                <a-input
                  v-model:value="formState.sender_fullname"
                  placeholder="Sender fullname"
                >
                  <template #prefix
                    ><UserOutlined
                      style="color: rgba(0, 0, 0, 0.25)" /></template
                ></a-input>
              </a-form-item>
              <a-form-item
                name="sender_phone"
                label="Phone"
                :rules="[
                  { required: true, message: 'Please enter phone number!' },
                  {
                    pattern: /^(0)\d{10}$/,
                    message: 'Please enter a valid phone number!',
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.sender_phone"
                  placeholder="Sender phone number"
                >
                  <template #prefix
                    ><PhoneOutlined style="color: rgba(0, 0, 0, 0.25)"
                  /></template>
                </a-input>
              </a-form-item>
              <a-form-item
                name="sender_email"
                label="Sender email"
                :rules="[
                  {
                    required: true,
                    message: 'Please enter sender email address!',
                  },
                  {
                    type: 'email',
                    message: 'Please enter a valid email address as sender!',
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.sender_email"
                  placeholder="Sender email"
                >
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
                <a-select
                  v-model:value="formState.pickup_address"
                  show-search
                  placeholder="Enter pickup address"
                  :filter-option="false"
                  :not-found-content="null"
                  @search="handlePickupAddressSearch"
                  @change="calculateDistance"
                >
                  <a-select-option
                    v-for="address in pickupAddressSuggestions"
                    :key="address.place_id"
                    :value="address.display_name"
                  >
                    {{ address.display_name }}
                  </a-select-option>
                </a-select>
              </a-form-item>
              <a-form-item
                name="delivery_address"
                label="Delivery Address"
                :rules="[
                  { required: true, message: 'Please enter delivery address!' },
                ]"
              >
                <a-select
                  v-model:value="formState.delivery_address"
                  show-search
                  placeholder="Enter delivery address"
                  :filter-option="false"
                  :not-found-content="null"
                  @search="handleDeliveryAddressSearch"
                  @change="calculateDistance"
                >
                  <a-select-option
                    v-for="address in deliveryAddressSuggestions"
                    :key="address.place_id"
                    :value="address.display_name"
                  >
                    {{ address.display_name }}
                  </a-select-option>
                </a-select>
              </a-form-item>
              <a-form-item
                name="recipient_fullname"
                label="Recipient fullname"
                :rules="[
                  {
                    required: true,
                    message: 'Please enter full name of recipient!',
                  },
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
                <a-input
                  v-model:value="formState.recipient_fullname"
                  placeholder="Recipient fullname"
                >
                  <template #prefix
                    ><UserOutlined
                      style="color: rgba(0, 0, 0, 0.25)" /></template
                ></a-input>
              </a-form-item>
              <a-form-item
                name="recipient_phone"
                label="Recipient phone"
                :rules="[
                  {
                    required: true,
                    message: 'Please enter phone number for recipient!',
                  },
                  {
                    pattern: /^[0-9]{10,15}$/,
                    message: 'Please enter a valid phone number for recipient!',
                  },
                ]"
              >
                <a-input
                  v-model:value="formState.recipient_phone"
                  placeholder="Recipient phone number"
                >
                  <template #prefix
                    ><PhoneOutlined style="color: rgba(0, 0, 0, 0.25)"
                  /></template>
                </a-input>
              </a-form-item>
              <a-form-item name="item_description" label="Item Description">
                <a-textarea
                  v-model:value="formState.item_description"
                  :maxlength="1000"
                  show-count
                  placeholder="Item description"
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
                  disabled
                />
              </a-form-item>

              <a-form-item
                label="Estimated delivery time"
                name="estimated_delivery_time"
              >
                <a-input
                  v-model:value="formState.estimated_delivery_time"
                  placeholder="Estimated delivery time"
                />
              </a-form-item>

              <a-form-item
                label="Actual delivery time"
                name="actual_delivery_time"
              >
                <a-input
                  v-model:value="formState.actual_delivery_time"
                  placeholder="Actual delivery time"
                />
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
                <a-input
                  v-model:value="formState.package_dimensions"
                  placeholder="Package dimensions"
                />
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
                  placeholder="Special instructions"
                />
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
                  placeholder="Riders notes"
                />
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
                  placeholder="Failed delivery reason"
                />
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
                  <a-radio value="2">Medium</a-radio>
                  <a-radio value="3">High</a-radio>
                </a-radio-group>
              </a-form-item>

              <a-form-item
                name="cancellation_reason"
                label="Cancellation reason"
              >
                <a-textarea
                  v-model:value="formState.cancellation_reason"
                  placeholder="Cancellation reason"
                />
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
import { ref } from 'vue';
import SideBar from '@/components/template/SidebarTemplate.vue';
import HeaderTemplate from '@/components/template/HeaderTemplate.vue';
import FooterTemplate from '@/components/template/FooterTemplate.vue';
import authService from '@/api/services';
import type { NominatimAddress } from '@/types/types';

import {
  UserOutlined,
  PhoneOutlined,
  MailOutlined,
} from '@ant-design/icons-vue';

// Define form state
const formState = ref({
  sender_fullname: '',
  recipient_fullname: '',
  pickup_address: '',
  delivery_address: '',
  item_description: '',
  status: 'Pending',
  sender_phone: '',
  recipient_phone: '',
  sender_email: '',
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

// Address suggestions
const pickupAddressSuggestions = ref<NominatimAddress[]>([]);
const deliveryAddressSuggestions = ref<NominatimAddress[]>([]);

// Fetch address suggestions from Nominatim
const fetchAddressSuggestions = async (
  query: string
): Promise<NominatimAddress[]> => {
  const response = await fetch(
    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
      query
    )}&limit=5`
  );
  const data = await response.json();
  return data as NominatimAddress[];
};

// Handle pickup address search
const handlePickupAddressSearch = async (query: string) => {
  if (query) {
    const suggestions = await fetchAddressSuggestions(query);
    pickupAddressSuggestions.value = suggestions;
  } else {
    pickupAddressSuggestions.value = [];
  }
};

// Handle delivery address search
const handleDeliveryAddressSearch = async (query: string) => {
  if (query) {
    const suggestions = await fetchAddressSuggestions(query);
    deliveryAddressSuggestions.value = suggestions;
  } else {
    deliveryAddressSuggestions.value = [];
  }
};

// 1. Define coordinate type
type Coordinate = [number, number];

// 2. Update getCoordinates to return Coordinate
const getCoordinates = async (address: string): Promise<Coordinate> => {
  const response = await fetch(
    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`
  );
  const data = await response.json();
  if (data.length > 0) {
    return [parseFloat(data[0].lon), parseFloat(data[0].lat)];
  }
  throw new Error('Address not found');
};

// 3. Update getDistance to expect Coordinate type
const getDistance = async (
  origin: Coordinate,
  destination: Coordinate
): Promise<number> => {
  const response = await fetch(
    `https://router.project-osrm.org/route/v1/driving/${origin[0]},${origin[1]};${destination[0]},${destination[1]}?overview=false`
  );
  const data = await response.json();
  if (data.routes && data.routes.length > 0) {
    return data.routes[0].distance / 1000; // Distance in kilometers
  }
  throw new Error('Distance calculation failed: No route found');
};

// 4. Update the calling code
const calculateDistance = async () => {
  const pickupAddress = formState.value.pickup_address;
  const deliveryAddress = formState.value.delivery_address;

  if (pickupAddress && deliveryAddress) {
    try {
      const pickupCoords = await getCoordinates(pickupAddress);
      const deliveryCoords = await getCoordinates(deliveryAddress);
      const distance = await getDistance(pickupCoords, deliveryCoords);
      formState.value.distance = distance;
    } catch (error) {
      console.error('Error calculating distance:', error);
      formState.value.distance = 0;
    }
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
