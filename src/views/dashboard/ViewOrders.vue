<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-table
            :columns="columns"
            :data-source="data"
            :row-class-name="
              (_record, index) => (index % 2 === 1 ? 'table-striped' : null)
            "
            bordered
            sticky
            :scroll="{ x: 1500, y: 240 }"
            @resizeColumn="handleResizeColumn"
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
        </div>
        <FooterTemplate />
      </a-layout>
    </a-layout>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue';
import { SmileOutlined, DownOutlined } from '@ant-design/icons-vue';
import SideBar from '@/components/template/SidebarTemplate.vue';
import HeaderTemplate from '@/components/template/HeaderTemplate.vue';
import FooterTemplate from '@/components/template/FooterTemplate.vue';
import type { TableColumnsType } from 'ant-design-vue';

const columns = ref<TableColumnsType>([
  {
    title: 'Customer name',
    dataIndex: 'name',
    key: 'name',
    ellipsis: true,
  },
  {
    title: 'Phone number',
    key: 'phone',
    dataIndex: 'phone',
  },
  {
    title: 'Pickup time',
    dataIndex: 'pickup-time',
    key: 'pickup-time',
  },
  {
    title: 'Pickup address',
    dataIndex: 'pickup-address',
    key: 'pickup-address',
    ellipsis: true,
    resizable: true,
    width: 100,
    minWidth: 100,
    maxWidth: 200,
  },
  {
    title: 'Delivery address',
    key: 'delivery-address',
    dataIndex: 'delivery-address',
    ellipsis: true,
  },
  {
    title: 'Delivery type',
    key: 'type',
    dataIndex: 'type',
  },
  {
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
  },
  {
    title: 'Payment status',
    key: 'payment-status',
    dataIndex: 'payment-status',
  },
  {
    title: 'Total cost',
    key: 'cost',
    dataIndex: 'cost',
  },
  {
    title: 'Discount',
    key: 'discount',
    dataIndex: 'discount',
  },
  {
    title: 'Time slot',
    key: 'slot',
    dataIndex: 'slot',
  },
  {
    title: 'Distance',
    key: 'distance',
    dataIndex: 'distance',
  },
  {
    title: 'Estimated delivery time',
    key: 'estimated-time',
    dataIndex: 'estimated-time',
  },
  {
    title: 'Actual delivery time',
    key: 'actual-time',
    dataIndex: 'actual-time',
  },
  {
    title: 'Date',
    key: 'date',
    dataIndex: 'date',
  },
  {
    title: 'Action',
    key: 'action',
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

function handleResizeColumn(w, col) {
  col.width = w;
}
</script>

<style scoped>
[data-doc-theme='light'] .ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
[data-doc-theme='dark'] .ant-table-striped :deep(.table-striped) td {
  background-color: rgb(29, 29, 29);
}
</style>
