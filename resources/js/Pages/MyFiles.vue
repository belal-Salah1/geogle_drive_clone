<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
defineOptions({ layout: AuthenticatedLayout });
import { router } from '@inertiajs/vue3';

const { files } = defineProps({
  files: Object,
  folder: Object,
  ancestors: Object,
});

function openFolder(file) {
  if (!file.is_folder) {
    return;
  }
  router.visit(route('myFiles', { folder: file.path }));
}
</script>

<template>
  <nav class="flex items-center justify-start p-2 mt-3">
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
  </nav>
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
        class="cursor-pointer"
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
          {{ file.size }}
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
