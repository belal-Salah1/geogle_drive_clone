<script setup>
import { emitter, FILE_UPLOAD_STARTED } from '@/event-bus';
import { MenuItem } from '@headlessui/vue';

function onChange(event) {
  emitter.emit(FILE_UPLOAD_STARTED, event.target.files);
}
</script>
<template>
  <MenuItem>
    <a class="text-gray-700 block px-4 py-2 text-sm relative" href="#"
      >Upload files
      <input
        type="file"
        name=""
        id=""
        class="absolute left-0 top-0 bottom-0 right-0 cursor-pointer opacity-0"
        @change="onChange"
        multiple
      />
    </a>
  </MenuItem>
</template>
