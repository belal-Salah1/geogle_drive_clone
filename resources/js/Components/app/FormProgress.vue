<script setup>
// imports

// users

// refs

// props & emits
const props = defineProps({
  form: Object,
});
// computed

// methods

// hooks
</script>

<template>
  <div
    v-if="form.progress"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
  >
    <div
      class="bg-gradient-to-br from-blue-50 to-indigo-100 border border-blue-200 shadow-2xl rounded-2xl p-6 flex flex-col w-[320px] backdrop-blur-sm transform transition-all duration-300 ease-out"
    >
      <div class="flex items-center mb-4">
        <div
          class="animate-spin rounded-full h-6 w-6 border-3 border-blue-500 border-t-transparent mr-4"
        ></div>
        <span class="text-gray-800 font-semibold text-base"
          >Uploading {{ form.files.length }} file{{
            form.files.length > 1 ? 's' : ''
          }}</span
        >
      </div>
      <div
        class="h-5 bg-gray-200 rounded-full overflow-hidden shadow-inner mb-3"
      >
        <div
          class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500 ease-out shadow-sm"
          :style="{ width: form.progress.percentage + '%' }"
        ></div>
      </div>
      <div class="text-sm text-gray-600 text-center font-medium">
        {{ form.progress.percentage }}% complete
      </div>
    </div>
  </div>
</template>
