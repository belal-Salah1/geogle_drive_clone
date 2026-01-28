<script setup>
import { MenuItem } from '@headlessui/vue';
import { emitter, FILE_UPLOAD_STARTED } from '@/event-bus';

function onChange(event) {
  emitter.emit(FILE_UPLOAD_STARTED, event.target.files);
}
</script>
<template>
  <MenuItem>
    <a href="#" class="text-gray-700 block px-4 py-2 text-sm relative"
      >Upload folder
      <input
        type="file"
        name=""
        id=""
        class="absolute left-0 top-0 bottom-0 right-0 cursor-pointer opacity-0"
        @change="onChange"
        multiple
        directory
        webkitdirectory
      />
    </a>
  </MenuItem>
</template>
