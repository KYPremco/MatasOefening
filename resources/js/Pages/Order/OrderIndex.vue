<script setup>

import SearchInput from "../../Components/SearchInput.vue";
import {computed, ref} from "vue";
import _ from "lodash";

const props = defineProps({
  orders: Object,
});

const flatProducts = computed(() => {
  let orders = [];
  props.orders.data.forEach(order => {
    orders.push({
      order_id: order.id,
      type: order.type,
      price: order.product.price,
      name: order.product?.assembly?.name,
      product: order.product,
    });
  });
  return orders;
});

const sortType = ref("order_id");
const arrangeType = ref("asc");
const sortedProducts = computed(() => {
  return _.orderBy(flatProducts.value, [sortType.value], [arrangeType.value]);
});

const test = computed(() => {
  return sortType;
})

function changeSorter(sortOn) {
  if (sortOn === sortType.value) {
    arrangeType.value = arrangeType.value === 'asc' ? 'desc' : 'asc';
    return;
  }

  arrangeType.value = "asc";
  sortType.value = sortOn;
}
</script>


<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="flex flex-col items-center mt-3 md:mt-6">
    <div class="w-full sm:max-w-4xl mt-6 ">
      <div
          v-if="$page.props.flash.message"
          class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
          role="alert"
      >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
      </div>
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
              <tr>
                <th colspan="4" class="py-3.5 px-4 text-left text-sm font-semibold text-gray-900">
                  <search-input :route-name="route('orders.index')"/>
                </th>
              </tr>
              <tr>
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                  <div class="flex justify-between cursor-pointer" @click="() => changeSorter('order_id')">
                    OrderId
                    <svg v-if="sortType === 'order_id' && arrangeType === 'asc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="11" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="13" y2="18"/>
                      <polyline points="15 9 18 6 21 9"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                    <svg v-if="sortType === 'order_id' && arrangeType === 'desc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="13" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="11" y2="18"/>
                      <polyline points="15 15 18 18 21 15"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                  </div>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <div class="flex justify-between cursor-pointer" @click="() => changeSorter('name')">
                    Naam
                    <svg v-if="sortType === 'name' && arrangeType === 'asc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="11" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="13" y2="18"/>
                      <polyline points="15 9 18 6 21 9"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                    <svg v-if="sortType === 'name' && arrangeType === 'desc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="13" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="11" y2="18"/>
                      <polyline points="15 15 18 18 21 15"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                  </div>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <div class="flex justify-between cursor-pointer" @click="() => changeSorter('type')">
                    Type
                    <svg v-if="sortType === 'type' && arrangeType === 'asc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="11" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="13" y2="18"/>
                      <polyline points="15 9 18 6 21 9"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                    <svg v-if="sortType === 'type' && arrangeType === 'desc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="13" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="11" y2="18"/>
                      <polyline points="15 15 18 18 21 15"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                  </div>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <div class="flex justify-between cursor-pointer" @click="() => changeSorter('price')">
                    Prijs
                    <svg v-if="sortType === 'price' && arrangeType === 'asc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="11" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="13" y2="18"/>
                      <polyline points="15 9 18 6 21 9"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                    <svg v-if="sortType === 'price' && arrangeType === 'desc'" class="h-4 w-4 text-black" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <line x1="4" y1="6" x2="13" y2="6"/>
                      <line x1="4" y1="12" x2="11" y2="12"/>
                      <line x1="4" y1="18" x2="11" y2="18"/>
                      <polyline points="15 15 18 18 21 15"/>
                      <line x1="18" y1="6" x2="18" y2="18"/>
                    </svg>
                  </div>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white">
              <template v-for="order in sortedProducts" :key="order.id">
                <tr >
                  <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    {{ order.order_id }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-500">{{ order.name || "Product niet gevonden" }}</td>
                  <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-500">{{ order.type }}</td>
                  <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-500">{{ order.price }}</td>
                </tr>
                <tr v-for="component in order.product?.assembly?.components" :key="component.id" class="bg-gray-50">
                  <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">

                  </td>
                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ component.name }}</td>
                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">component</td>
                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ order.price }}</td>
                </tr>
              </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
