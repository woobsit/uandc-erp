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
                    <a-typography-text> No records</a-typography-text>
                  </template>
                  <template v-else>
                    <template v-if="column.key === 'name'">
                      <a>
                        {{ record.name }}
                      </a>
                    </template>
                    <template v-if="column.key === 'phone'">
                      <a>
                        {{ record.phone }}
                      </a>
                    </template>
                    <template v-if="column.key === 'pickup_time'">
                      <a>
                        {{ record.pickup_time }}
                      </a>
                    </template>
                    <template v-if="column.key === 'pickup_address'">
                      <a>
                        {{ record.pickup_address }}
                      </a>
                    </template>
                    <template v-if="column.key === 'delivery_address'">
                      <a>
                        {{ record.delivery_address }}
                      </a>
                    </template>
                    <template v-if="column.key === 'type'">
                      <a>
                        {{ record.type }}
                      </a>
                    </template>
                    <template v-if="column.key === 'status'">
                      <a>
                        {{ record.status }}
                      </a>
                    </template>
                    <template v-if="column.key === 'payment_status'">
                      <a>
                        {{ record.payment_status }}
                      </a>
                    </template>
                    <template v-if="column.key === 'cost'">
                      <a>
                        {{ record.cost }}
                      </a>
                    </template>
                    <template v-if="column.key === 'discount'">
                      <a>
                        {{ record.discount }}
                      </a>
                    </template>
                    <template v-if="column.key === 'slot'">
                      <a>
                        {{ record.slot }}
                      </a>
                    </template>
                    <template v-if="column.key === 'distance'">
                      <a>
                        {{ record.distance }}
                      </a>
                    </template>
                    <template v-if="column.key === 'discount'">
                      <a>
                        {{ record.discount }}
                      </a>
                    </template>
                    <template v-if="column.key === 'estimated_time'">
                      <a>
                        {{ record.estimated_time }}
                      </a>
                    </template>
                    <template v-if="column.key === 'actual_time'">
                      <a>
                        {{ record.actual_time }}
                      </a>
                    </template>
                    <template v-if="column.key === 'date'">
                      <a>
                        {{ record.date }}
                      </a>
                    </template>
                    <template v-if="column.key === 'action'">
                      <a>
                        {{ record.action }}
                      </a>
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
import { ref, onMounted, computed } from 'vue';
import SideBar from '@/components/template/SidebarTemplate.vue';
import HeaderTemplate from '@/components/template/HeaderTemplate.vue';
import FooterTemplate from '@/components/template/FooterTemplate.vue';
import type { TableColumnsType } from 'ant-design-vue';
import authService from '@/api/services';
import { notify } from '@/utils/notification';

interface Column {
  width?: number;
  // ... you can add more properties if needed
}

// Define a function with explicit types for rowClassName
const rowClassName = (_record: any, index: number): string | null => {
  return index % 2 === 1 ? 'table-striped' : null;
};

// Define a function with explicit types for handleResizeColumn
function handleResizeColumn(w: number, col: Column): void {
  col.width = w;
}

const columns = ref<TableColumnsType>([
  {
    title: 'Customer name',
    dataIndex: 'name',
    key: 'name',
    ellipsis: true,
    width: 150,
  },
  {
    title: 'Phone number',
    key: 'phone',
    dataIndex: 'phone',
    ellipsis: true,
    width: 130,
  },
  {
    title: 'Pickup time',
    dataIndex: 'pickup_time',
    key: 'pickup_time',
    ellipsis: true,
    width: 110,
  },
  {
    title: 'Pickup address',
    dataIndex: 'pickup_address',
    key: 'pickup_address',
    ellipsis: true,
    resizable: true,
    width: 200,
  },
  {
    title: 'Delivery address',
    key: 'delivery_address',
    dataIndex: 'delivery_address',
    ellipsis: true,
    width: 200,
  },
  {
    title: 'Delivery type',
    key: 'type',
    dataIndex: 'type',
    ellipsis: true,
    width: 130,
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
    width: 150,
  },
  {
    title: 'Total cost',
    key: 'cost',
    dataIndex: 'cost',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Discount',
    key: 'discount',
    dataIndex: 'discount',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Time slot',
    key: 'slot',
    dataIndex: 'slot',
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
    key: 'estimated_time',
    dataIndex: 'estimated_time',
    width: 100,
    ellipsis: true,
  },
  {
    title: 'Actual delivery time',
    key: 'actual_time',
    dataIndex: 'actual_time',
    width: 100,
    ellipsis: true,
  },
  {
    title: 'Date',
    key: 'date',
    dataIndex: 'date',
    ellipsis: true,
    width: 100,
  },
  {
    title: 'Action',
    key: 'action',
    ellipsis: true,
    width: 100,
  },
]);

const loading = ref(true);
let data = ref<any[]>([]);
const noRecord = ref(false);
const fetchOrders = async () => {
  loading.value = true;
  try {
    // Call the authService's getAllOrders method
    const response = await authService.getAllOrders();
    if (response.status === 201) {
      data = response.result;
    } else if (response.status === 404 || response.result.length === 0) {
      noRecord.value = true;
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

// Optionally, if you need pagination support:
const pagination = computed(() => ({
  total: 200,
  current: 1, // Adjust as needed
  pageSize: 10, // Adjust as needed
}));
</script>

<style scoped>
[data-doc-theme='light'] .ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
[data-doc-theme='dark'] .ant-table-striped :deep(.table-striped) td {
  background-color: rgb(29, 29, 29);
}
</style>
