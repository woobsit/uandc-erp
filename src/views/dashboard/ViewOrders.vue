<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <div class="table-container">
            <a-table
              :columns="columns"
              :data-source="data"
              :row-class-name="rowClassName"
              bordered
              sticky
              :scroll="{ x: 1500, y: 240 }"
              @resizeColumn="handleResizeColumn"
              @change="handleTableChange"
              class="table-list"
              size="small"
              :pagination="pagination"
            >
              <template #bodyCell="{ column, record }">
                <template v-if="loading">
                  <a-skeleton active />
                  <a-skeleton active />
                  <a-skeleton active />
                  <a-skeleton active />
                </template>
                <template v-else>
                  <template v-if="noRecord">
                    <a-typography-text>No records</a-typography-text>
                  </template>
                  <template v-else>
                    <template v-if="column.key === 'fullname'">
                      <a>{{ record.fullname }}</a>
                    </template>
                    <template v-if="column.key === 'customer_phone'">
                      <a>{{ record.customer_phone }}</a>
                    </template>
                    <template v-if="column.key === 'pickup_time'">
                      <a>{{ record.pickup_time }}</a>
                    </template>
                    <template v-if="column.key === 'pickup_address'">
                      <a>{{ record.pickup_address }}</a>
                    </template>
                    <template v-if="column.key === 'delivery_address'">
                      <a>{{ record.delivery_address }}</a>
                    </template>
                    <template v-if="column.key === 'delivery_type'">
                      <a>{{ record.delivery_type }}</a>
                    </template>
                    <template v-if="column.key === 'status'">
                      <a>{{ record.status }}</a>
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
                      <a>{{ record.delivery_time_slot }}</a>
                    </template>
                    <template v-if="column.key === 'distance'">
                      <a>{{ record.distance }}</a>
                    </template>
                    <template v-if="column.key === 'estimated_delivery_time'">
                      <a>{{ record.estimated_delivery_time }}</a>
                    </template>
                    <template v-if="column.key === 'actual_delivery_time'">
                      <a>{{ record.actual_delivery_time }}</a>
                    </template>
                    <template v-if="column.key === 'created_at'">
                      <a>{{ record.created_at }}</a>
                    </template>
                    <template v-if="column.key === 'action'">
                      <a>{{ record.action }}</a>
                    </template>
                  </template>
                </template>
              </template>
            </a-table>
            <div class="order-chart">chart</div>
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
import { notify } from '@/utils/notification';

interface Column {
  width?: number;
  // Additional column properties as needed
}

// Function for striped rows
const rowClassName = (_record: any, index: number): string | null => {
  return index % 2 === 1 ? 'table-striped' : null;
};

// Function to handle column resize
function handleResizeColumn(w: number, col: Column): void {
  col.width = w;
}

// Define table columns (make sure keys match your backend data structure)
const columns = ref<TableColumnsType>([
  {
    title: 'Customer name',
    dataIndex: 'fullname',
    key: 'fullname',
    ellipsis: true,
    width: 150,
    resizable: true,
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
    title: 'Action',
    key: 'action',
    ellipsis: true,
    width: 100,
  },
]);

// Reactive variables for loading, data, and noRecord
const loading = ref(true);
const data = ref<any[]>([]);
const noRecord = ref(false);

// Reactive pagination data
const pagination = ref({
  total: 0,
  current: 1,
  pageSize: 10,
});

// Define an interface for API parameters
interface APIParams {
  page: number;
  results: number;
}

// Fetch orders with pagination parameters
const fetchOrders = async (params: Partial<APIParams> = {}) => {
  loading.value = true;
  try {
    const page = params.page || pagination.value.current;
    const results = params.results || pagination.value.pageSize;

    const queryParams: APIParams = { page, results };

    // Call getAllOrders with queryParams. Ensure authService.getAllOrders
    // is updated to accept an object.
    const response = await authService.getAllOrders(queryParams);

    if (response.status === 201) {
      data.value = response.result;
      pagination.value = {
        total: response.pagination.total,
        current: response.pagination.current_page,
        pageSize: response.pagination.per_page,
      };
      noRecord.value = data.value.length === 0;
    } else if (
      response.status === 404 ||
      (response.result && response.result.length === 0)
    ) {
      noRecord.value = true;
      data.value = [];
    } else if (response.status === 500) {
      notify({
        type: 'error',
        message: 'System Error',
        description: response.message,
      });
    } else {
      notify({
        type: 'error',
        message: 'Error',
        description: 'An unexpected error occurred',
      });
    }
  } catch (error) {
    notify({
      type: 'error',
      message: 'Error',
      description: 'An unexpected error occurred. Please try again.',
    });
  } finally {
    loading.value = false;
  }
};

// Trigger fetchOrders on component mount
onMounted(() => {
  fetchOrders();
});

// Handle table pagination change event
const handleTableChange = (paginationInfo: any) => {
  pagination.value.current = paginationInfo.current;
  pagination.value.pageSize = paginationInfo.pageSize;
  fetchOrders({
    page: paginationInfo.current,
    results: paginationInfo.pageSize,
  });
};
</script>

<style scoped>
[data-doc-theme='light'] .ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
[data-doc-theme='dark'] .ant-table-striped :deep(.table-striped) td {
  background-color: rgb(29, 29, 29);
}
</style>
