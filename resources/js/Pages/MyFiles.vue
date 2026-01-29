<script setup>
import FileIcon from '@/Components/app/fileIcon.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import fileIcon from '@/Components/app/fileIcon.vue';
import { router } from '@inertiajs/vue3';
import { onMounted, ref, onUpdated, computed } from 'vue';
import { httpGet } from '@/helper/http-helper';
import DeleteFilesButton from '@/Components/app/DeleteFilesButton.vue';

import Checkbox from '@/Components/Checkbox.vue';
defineOptions({ layout: AuthenticatedLayout });
const props = defineProps({
  files: Object,
  folder: Object,
  ancestors: Object,
});

const loadMoreIntersect = ref(null);
const allSelected = ref(false);
const selected = ref({});
const allFiles = ref({
  data: props.files.data,
  next: null,
});

const selectedIds = computed(() => {
  return Object.entries(selected.value)
    .filter((a) => a[1])
    .map((a) => a[0]);
});

function openFolder(file) {
  if (!file.is_folder) {
    return;
  }
  router.visit(route('myFiles', { folder: file.path }));
}
function loadMore() {
  console.log(allFiles.value.next);
  if (allFiles.value.next == null) {
    return;
  }
  httpGet(allFiles.value.next).then((res) => {
    allFiles.value.data = [...allFiles.value.data, ...res.data];
    allFiles.value.next = res.links.next;
  });
}

function onSelectAllChange() {
  allFiles.value.data.forEach((f) => {
    selected.value[f.id] = allSelected.value;
  });
}

function toggleFileSelect(file) {
  selected.value[file.id] = !selected.value[file.id];
  onSelectCheckboxChange(file);
}

function onSelectCheckboxChange(file) {
  if (!selected.value[file.id]) {
    allSelected.value = false;
  } else {
    let checked = true;
    for (let file of allFiles.value.data) {
      if (!selected.value[file.id]) {
        checked = false;
        break;
      }
    }
    allSelected.value = checked;
  }
}
function onDelete() {
  allSelected.value = false;
  selected.value = {};
}
onUpdated(() => {
  allFiles.value = {
    data: props.files.data,
    next: props.files.links.next,
  };
});

onMounted(() => {
  const observer = new IntersectionObserver(
    (entries) => entries.forEach((entry) => entry.isIntersecting && loadMore()),
    {
      rootMargin: '-250px 0px 0px 0px',
      threshold: 1.0,
    }
  );
  observer.observe(loadMoreIntersect.value);
});
</script>

<template>
  <nav class="flex items-center justify-between p-2 mt-3">
    <ol class="inline-flex items-center space-x-1">
      <li
        v-for="(ans, index) of ancestors.data"
        :key="ans.id"
        class="inline-flex items-center"
      >
        <Link
          v-if="!ans.parent_id"
          :href="route('myFiles')"
          class="inline-flex items-center text-lg font-semibold text-gray-600 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-blue-400"
        >
          <svg
            data-slot="icon"
            fill="none"
            stroke-width="1.5"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            class="w-4 h-4 mr-1"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
            ></path>
          </svg>
          My Files
        </Link>
        <div v-else class="flex items-center">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
          ></path>

          <Link
            :href="route('myFiles', { folder: ans.path })"
            class="ml-0 text-lg font-semibold text-gray-600 hover:text-blue-600 md:ml-0 dark:text-gray-400 dark:hover:text-blue-400"
            >{{ ans.name }}</Link
          >
        </div>
        <svg
          v-if="index < ancestors.data.length - 1"
          class="w-4 h-4 mx-1 text-gray-500 dark:text-gray-400"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 000-1.414z"
            clip-rule="evenodd"
          />
        </svg>
      </li>
    </ol>
    <div>
      <DeleteFilesButton
        :delete-all="allSelected"
        :delete-ids="selectedIds"
        @delete="onDelete"
      />
    </div>
  </nav>
  {{ selectedIds }}
  <div class="flex-1 overflow-auto">
    <table v-if="allFiles.data.length" class="min-w-full">
      <thead class="bg-gray-100 border-b">
        <th
          class="text-sm font-medium text-gray-900 px-6 py-4 text-left w-[30px] max-w-[30px] pr-0"
        >
          <Checkbox @change="onSelectAllChange" v-model:checked="allSelected" />
        </th>
        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
          Name
        </th>
        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
          Owner
        </th>
        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
          Last Modified
        </th>
        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
          Size
        </th>
      </thead>
      <tbody>
        <tr
          v-for="file of allFiles.data"
          @click="($event) => toggleFileSelect(file)"
          :key="file.id"
          @dblclick="openFolder(file)"
          :class="`cursor-pointer hover:bg-gray-100 ${selected[file?.id] || allSelected ? 'bg-blue-100' : 'bg-white'}`"
        >
          <td
            class="border-b transition duration-300 ease-in-out px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-[30px] max-w-[30px] pr-0"
          >
            <Checkbox
              @change="onSelectCheckboxChange(file)"
              v-model="selected[file.id]"
              :checked="selected[file.id] || allSelected"
            />
          </td>
          <td
            class="border-b transition duration-300 ease-in-out flex items-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            <FileIcon :file="file" />
            {{ file.name }}
          </td>
          <td
            class="border-b transition duration-300 ease-in-out px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            {{ file.owner }}
          </td>
          <td
            class="border-b transition duration-300 ease-in-out px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            {{ file.updated_at }}
          </td>
          <td
            class="border-b transition duration-300 ease-in-out px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            {{ file.size }}
          </td>
        </tr>
      </tbody>
    </table>
    <div
      v-if="!allFiles.data.length"
      class="flex flex-col items-center justify-center h-96 text-gray-500"
    >
      There is no files in this folder.
    </div>
    <div ref="loadMoreIntersect"></div>
  </div>
</template>
