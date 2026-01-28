<script setup>
// imports
import {
  isImageFile,
  isVideoFile,
  isAudioFile,
  isPdfFile,
  isWordFile,
  isExcelFile,
  isTextFile,
  isArchiveFile,
} from '@/helper/file-helper';

// users

// refs

// props & emits
const { file } = defineProps({
  file: Object,
});
// computed

// methods

// hooks
</script>

<template>
  <span class="h-5 w-5 inline-flex items-center justify-center mr-2">
    <svg
      v-if="file.is_folder"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="size-6"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"
      />
    </svg>
    <template v-else>
      <img
        src="/images/photo.png"
        v-if="isImageFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/video.png"
        v-else-if="isVideoFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/audio.png"
        v-else-if="isAudioFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/pdf.png"
        v-else-if="isPdfFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/word-processor.png"
        v-else-if="isWordFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/sheets.png"
        v-else-if="isExcelFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/txt.png"
        v-else-if="isTextFile(file.name)"
        class="w-6 h-6"
      />
      <img
        src="/images/zip.png"
        v-else-if="isArchiveFile(file.name)"
        class="w-6 h-6"
      />
      <img src="/images/attach-file.png" v-else class="w-6 h-6" />
    </template>
  </span>
</template>
