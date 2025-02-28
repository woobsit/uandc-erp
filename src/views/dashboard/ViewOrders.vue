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
            >
              <!-- <template #headerCell="{ column }">
          <template v-if="column.key === 'name'">
            <span>
              <smile-outlined />
              #
            </span> 
          </template>
        </template> -->

              <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'name'">
                  <a>
                    {{ record.name }}
                  </a>
                </template>
                <template v-else-if="column.key === 'tags'">
                  <span>
                    <a-tag
                      v-for="tag in record.tags"
                      :key="tag"
                      :color="
                        tag === 'loser'
                          ? 'volcano'
                          : tag.length > 5
                            ? 'geekblue'
                            : 'green'
                      "
                    >
                      {{ tag.toUpperCase() }}
                    </a-tag>
                  </span>
                </template>
                <template v-else-if="column.key === 'action'">
                  <span>
                    <a>Invite 一 {{ record.name }}</a>
                    <a-divider type="vertical" />
                    <a>Delete</a>
                    <a-divider type="vertical" />
                    <a class="ant-dropdown-link">
                      More actions
                      <down-outlined />
                    </a>
                  </span>
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
import { ref } from 'vue';
import { DownOutlined } from '@ant-design/icons-vue';
import SideBar from '@/components/template/SidebarTemplate.vue';
import HeaderTemplate from '@/components/template/HeaderTemplate.vue';
import FooterTemplate from '@/components/template/FooterTemplate.vue';
import type { TableColumnsType } from 'ant-design-vue';

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
    dataIndex: 'pickup-time',
    key: 'pickup-time',
    ellipsis: true,
    width: 110,
  },
  {
    title: 'Pickup address',
    dataIndex: 'pickup-address',
    key: 'pickup-address',
    ellipsis: true,
    resizable: true,
    width: 200,
  },
  {
    title: 'Delivery address',
    key: 'delivery-address',
    dataIndex: 'delivery-address',
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
    key: 'payment-status',
    dataIndex: 'payment-status',
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
    key: 'estimated-time',
    dataIndex: 'estimated-time',
    width: 100,
    ellipsis: true,
  },
  {
    title: 'Actual delivery time',
    key: 'actual-time',
    dataIndex: 'actual-time',
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

const data = [
  {
    key: '1',
    name: 'John Brown',
    age: 32,
    address: 'New York No. 1 Lake Park',
    tags: ['nice', 'developer'],
  },
  {
    key: '2',
    name: 'Jim Green',
    age: 42,
    address: 'London No. 1 Lake Park',
    tags: ['loser'],
  },
];
</script>

<style scoped>
[data-doc-theme='light'] .ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
[data-doc-theme='dark'] .ant-table-striped :deep(.table-striped) td {
  background-color: rgb(29, 29, 29);
}
</style>
