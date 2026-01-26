<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
defineOptions({ layout: AuthenticatedLayout });
import { router } from '@inertiajs/vue3';

const { files } = defineProps({
  files: Object,
});

function openFolder(file) {
  if (!file.is_folder) {
    return;
  }
  router.visit(route('myFiles', { folder: file.path }));
}
</script>

<template>
  <table v-if="files.data.length" class="min-w-full">
    <thead class="bg-gray-100 border-b">
      <th class="text-sm font-medium trxt-gray-900 px-6 py-4 text-left">
        Name
      </th>
      <th class="text-sm font-medium trxt-gray-900 px-6 py-4 text-left">
        Owner
      </th>
      <th class="text-sm font-medium trxt-gray-900 px-6 py-4 text-left">
        Last Modified
      </th>
      <th class="text-sm font-medium trxt-gray-900 px-6 py-4 text-left">
        Size
      </th>
    </thead>
    <tbody>
      <tr
        v-for="file of files.data"
        :key="file.id"
        @dblclick="openFolder(file)"
      >
        <td
          class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
        >
          {{ file.name }}
        </td>
        <td
          class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
        >
          {{ file.owner }}
        </td>
        <td
          class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
        >
          {{ file.updated_at }}
        </td>
        <td
          class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
        >
          {{ file.size }} KB
        </td>
      </tr>
    </tbody>
  </table>
  <div
    v-else
    class="flex flex-col items-center justify-center h-96 text-gray-500"
  >
    There is no files in this folder.
  </div>
</template>
