<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-typography-title :level="3" class="table__header"
            >View Orders</a-typography-title
          >
          <div class="table-container">
            <template v-if="initialLoading">
              <a-space class="table__spinner-container">
                <a-spin size="large" />
              </a-space>
            </template>
            <template v-else>
              <a-table
                :columns="columns"
                :data-source="data"
                :row-class-name="rowClassName"
                bordered
                sticky
                :scroll="{ x: 1500, y: 500 }"
                @resizeColumn="handleResizeColumn"
                @change="handleTableChange"
                class="table-list"
                size="small"
                :pagination="pagination"
              >
                <template #bodyCell="{ column, record }">
                  <template v-if="loading">
                    <a-skeleton
                      :paragraph="{ rows: 1, width: '60%' }"
                      active
                      size="large"
                      :title="false"
                      class="custom-skeleton"
                    />
                  </template>
                  <template v-else-if="noRecord">
                    <a-typography-text>No records</a-typography-text>
                  </template>
                  <template v-else>
                    <template v-if="column.key === 'fullname'">
                      <router-link
                        :to="`/view/${record.id}`"
                        :title="record.fullname"
                        ><a-typography-text strong>{{
                          record.fullname
                        }}</a-typography-text></router-link
                      >
                    </template>
                    <template v-if="column.key === 'customer_phone'">
                      <a-typography-text :title="record.customer_phone">{{
                        record.customer_phone
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'pickup_time'">
                      <a-typography-text :title="record.pickup_time">{{
                        record.pickup_time
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'pickup_address'">
                      <a-typography-text :title="record.pickup_address">{{
                        record.pickup_address
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'delivery_address'">
                      <a-typography-text :title="record.delivery_address">{{
                        record.delivery_address
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'delivery_type'">
                      <a-tag
                        :color="
                          getStatusClass(record.delivery_type, 'delivery')
                        "
                        >{{ record.delivery_type }}</a-tag
                      >
                    </template>
                    <template v-if="column.key === 'status'">
                      <a-tag
                        :title="record.status"
                        :color="getStatusClass(record.status, 'order')"
                        >{{ record.status }}</a-tag
                      >
                    </template>
                    <template v-if="column.key === 'payment_status'">
                      <a-tag
                        :color="
                          getStatusClass(record.payment_status, 'payment')
                        "
                        >{{ record.payment_status }}</a-tag
                      >
                    </template>
                    <template v-if="column.key === 'total_cost'">
                      <a-typography-text>{{
                        record.total_cost
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'discount'">
                      <a-typography-text>{{
                        record.discount
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'delivery_time_slot'">
                      <a-typography-text :title="record.delivery_time_slot">{{
                        record.delivery_time_slot
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'distance'">
                      <a-typography-text>{{
                        record.distance
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'estimated_delivery_time'">
                      <a-typography-text
                        :title="record.estimated_delivery_time"
                        >{{ record.estimated_delivery_time }}</a-typography-text
                      >
                    </template>
                    <template v-if="column.key === 'actual_delivery_time'">
                      <a-typography-text :title="record.actual_delivery_time">{{
                        record.actual_delivery_time
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'created_at'">
                      <a-typography-text :title="record.created_at">{{
                        record.created_at
                      }}</a-typography-text>
                    </template>
                    <template v-if="column.key === 'action'">
                      <a-space :size="[10, 'small']" wrap>
                        <router-link :to="`/view/${record.id}`">
                          <eye-filled class="table__eye-icon" />
                        </router-link>
                        <!-- Edit Icon -->
                        <router-link :to="`/edit/${record.id}`">
                          <edit-filled class="table__edit-icon" />
                        </router-link>
                        <!-- Delete with Confirmation -->
                        <a-popconfirm
                          title="Are you sure you want to delete this item?"
                          ok-text="Yes"
                          cancel-text="No"
                          @confirm="() => handleDelete(record.id)"
                        >
                          <delete-filled class="table__delete-icon" />
                        </a-popconfirm>
                      </a-space>
                    </template>
                  </template>
                </template>
              </a-table>
            </template>
          </div>
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
import type { TableColumnsType } from 'ant-design-vue';
import authService from '@/api/services';
import type { Order } from '@/types/types';
import { EditFilled, EyeFilled, DeleteFilled } from '@ant-design/icons-vue';

// Function for striped rows
const rowClassName = (_record: any, index: number): string | null => {
  return index % 2 === 1 ? 'table-striped' : null;
};

// Function to handle column resize
const handleResizeColumn = (w: number, col: { width?: number }) => {
  col.width = w;
};

// Define table columns
const columns = ref<TableColumnsType>([
  {
    title: 'Customer name',
    dataIndex: 'fullname',
    key: 'fullname',
    ellipsis: true,
    width: 150,
    resizable: true,
    fixed: true,
  },
  {
    title: 'Phone number',
    key: 'customer_phone',
    dataIndex: 'customer_phone',
    ellipsis: true,
    width: 130,
    resizable: true,
  },
  {
    title: 'Pickup time',
    dataIndex: 'pickup_time',
    key: 'pickup_time',
    ellipsis: true,
    width: 110,
    resizable: true,
  },
  {
    title: 'Pickup address',
    dataIndex: 'pickup_address',
    key: 'pickup_address',
    ellipsis: true,
    width: 200,
    resizable: true,
  },
  {
    title: 'Delivery address',
    key: 'delivery_address',
    dataIndex: 'delivery_address',
    ellipsis: true,
    width: 200,
    resizable: true,
  },
  {
    title: 'Delivery type',
    key: 'delivery_type',
    dataIndex: 'delivery_type',
    ellipsis: true,
    width: 120,
  },
  {
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Payment status',
    key: 'payment_status',
    dataIndex: 'payment_status',
    ellipsis: true,
    width: 140,
  },
  {
    title: 'Total cost',
    key: 'total_cost',
    dataIndex: 'total_cost',
    ellipsis: true,
    width: 100,
    resizable: true,
  },
  {
    title: 'Discount',
    key: 'discount',
    dataIndex: 'discount',
    ellipsis: true,
    width: 100,
    resizable: true,
  },
  {
    title: 'Time slot',
    key: 'delivery_time_slot',
    dataIndex: 'delivery_time_slot',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Distance',
    key: 'distance',
    dataIndex: 'distance',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Estimated delivery time',
    key: 'estimated_delivery_time',
    dataIndex: 'estimated_delivery_time',
    ellipsis: true,
    width: 100,
    resizable: true,
  },
  {
    title: 'Actual delivery time',
    key: 'actual_delivery_time',
    dataIndex: 'actual_delivery_time',
    ellipsis: true,
    width: 140,
    resizable: true,
  },
  {
    title: 'Date',
    key: 'created_at',
    dataIndex: 'created_at',
    ellipsis: true,
    width: 100,
    resizable: true,
  },
  {
    title: '',
    key: 'action',
    ellipsis: true,
    width: 100,
  },
]);

// Loading and data states
const initialLoading = ref(true); // First load spinner
const loading = ref(false); // Pagination skeletons
const data = ref<Order[]>([]);
const noRecord = ref(false);

const pagination = ref({
  total: 0,
  current: 1,
  pageSize: 10,
});

// Fetch orders
const fetchOrders = async () => {
  loading.value = pagination.value.current > 1; // Show skeletons on pagination change
  initialLoading.value = pagination.value.current === 1; // Show spinner only on first load
  noRecord.value = false;

  try {
    const response = await authService.getAllOrders({
      page: pagination.value.current,
      results: pagination.value.pageSize,
    });

    if (response && response.status === 201 && response.result) {
      data.value = response.result || [];
      pagination.value.total = response.pagination?.total || 0;
      noRecord.value = data.value.length === 0;
    } else {
      noRecord.value = true;
    }
  } catch (error) {
    noRecord.value = true;
  } finally {
    loading.value = false;
    initialLoading.value = false;
  }
};

// Fetch data on mount
onMounted(() => {
  fetchOrders();
});

// Handle pagination change
const handleTableChange = (paginationInfo: any) => {
  pagination.value.current = paginationInfo.current;
  pagination.value.pageSize = paginationInfo.pageSize;
  fetchOrders();
};

//status, payment and delivery type color changes
const getStatusClass = (
  status: string,
  type: 'order' | 'payment' | 'delivery'
) => {
  const lowerStatus = status.toLowerCase();

  if (type === 'order') {
    switch (lowerStatus) {
      case 'cancelled':
        return 'red';
      case 'completed':
        return 'green';
      case 'processing':
        return 'orange';
      case 'pending':
        return '';
      default:
        return '';
    }
  }

  if (type === 'payment') {
    switch (lowerStatus) {
      case 'paid':
        return 'green';
      case 'unpaid':
        return 'red';
      case 'refunded':
        return 'purple';
      case 'failed':
        return 'volcano';
      default:
        return '';
    }
  }

  if (type === 'delivery') {
    switch (lowerStatus) {
      case 'standard':
        return 'blue';
      case 'express':
        return 'red';
      case 'same day':
        return 'green';
      case 'overnight':
        return 'purple';
      default:
        return '';
    }
  }
  return ''; // Default case
};

const handleDelete = (id: number) => {
  console.log(`Deleting item with ID: ${id}`);
  // Add API call to delete the item here
};
</script>

<style scoped>
.spinner-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  min-height: 300px;
}
[data-doc-theme='light'] .ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
[data-doc-theme='dark'] .ant-table-striped :deep(.table-striped) td {
  background-color: rgb(29, 29, 29);
}

:deep(.ant-skeleton-paragraph > li) {
  height: 7px !important; /* Adjust thickness */
}
</style>
