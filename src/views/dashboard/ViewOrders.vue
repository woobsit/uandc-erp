<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <div class="table-container">
            <template v-if="initialLoading">
              <a-space class="spinner-container">
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
                    <a-skeleton active />
                  </template>
                  <template v-else-if="noRecord">
                    <a-typography-text>No records</a-typography-text>
                  </template>
                  <template v-else>
                    <template v-if="column.key === 'fullname'">
                      <a :title="record.fullname">{{ record.fullname }}</a>
                    </template>
                    <template v-if="column.key === 'customer_phone'">
                      <a :title="record.customer_phone">{{
                        record.customer_phone
                      }}</a>
                    </template>
                    <template v-if="column.key === 'pickup_time'">
                      <a :title="record.pickup_time">{{
                        record.pickup_time
                      }}</a>
                    </template>
                    <template v-if="column.key === 'pickup_address'">
                      <a :title="record.pickup_address">{{
                        record.pickup_address
                      }}</a>
                    </template>
                    <template v-if="column.key === 'delivery_address'">
                      <a :title="record.delivery_address">{{
                        record.delivery_address
                      }}</a>
                    </template>
                    <template v-if="column.key === 'delivery_type'">
                      <a>{{ record.delivery_type }}</a>
                    </template>
                    <template v-if="column.key === 'status'">
                      <a :title="record.delivery_type">{{ record.status }}</a>
                    </template>
                    <template v-if="column.key === 'payment_status'">
                      <a>{{ record.payment_status }}</a>
                    </template>
                    <template v-if="column.key === 'total_cost'">
                      <a>{{ record.total_cost }}</a>
                    </template>
                    <template v-if="column.key === 'discount'">
                      <a>{{ record.discount }}</a>
                    </template>
                    <template v-if="column.key === 'delivery_time_slot'">
                      <a :title="record.delivery_time_slot">{{
                        record.delivery_time_slot
                      }}</a>
                    </template>
                    <template v-if="column.key === 'distance'">
                      <a>{{ record.distance }}</a>
                    </template>
                    <template v-if="column.key === 'estimated_delivery_time'">
                      <a :title="record.estimated_delivery_time">{{
                        record.estimated_delivery_time
                      }}</a>
                    </template>
                    <template v-if="column.key === 'actual_delivery_time'">
                      <a :title="record.actual_delivery_time">{{
                        record.actual_delivery_time
                      }}</a>
                    </template>
                    <template v-if="column.key === 'created_at'">
                      <a :title="record.created_at">{{ record.created_at }}</a>
                    </template>
                    <template v-if="column.key === 'action'">
                      <a>{{ record.action }}</a>
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
import type { Order } from '@/types';

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
</style>
