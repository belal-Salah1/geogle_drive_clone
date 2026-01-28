export function isImageFile(fileName) {
  const imageExtensions = [
    '.jpg',
    '.jpeg',
    '.png',
    '.gif',
    '.bmp',
    '.svg',
    '.webp',
    '.tiff',
  ];
  const lowerFileName = fileName.toLowerCase();
  return imageExtensions.some((ext) => lowerFileName.endsWith(ext));
}

export function isVideoFile(fileName) {
  const videoExtensions = [
    '.mp4',
    '.avi',
    '.mov',
    '.wmv',
    '.flv',
    '.mkv',
    '.webm',
  ];
  const lowerFileName = fileName.toLowerCase();
  return videoExtensions.some((ext) => lowerFileName.endsWith(ext));
}

export function isDocumentFile(fileName) {
  const documentExtensions = [
    '.pdf',
    '.doc',
    '.docx',
    '.xls',
    '.xlsx',
    '.ppt',
    '.pptx',
    '.txt',
    '.odt',
  ];
  const lowerFileName = fileName.toLowerCase();
  return documentExtensions.some((ext) => lowerFileName.endsWith(ext));
}

export function isAudioFile(fileName) {
  const audioExtensions = [
    '.mp3',
    '.wav',
    '.flac',
    '.aac',
    '.ogg',
    '.m4a',
    '.wma',
  ];
  const lowerFileName = fileName.toLowerCase();
  return audioExtensions.some((ext) => lowerFileName.endsWith(ext));
}

export function isPdfFile(fileName) {
  return fileName.toLowerCase().endsWith('.pdf');
}

export function isArchiveFile(fileName) {
  const archiveExtensions = [
    '.zip',
    '.rar',
    '.7z',
    '.tar',
    '.gz',
    '.bz2',
    '.xz',
  ];
  const lowerFileName = fileName.toLowerCase();
  return archiveExtensions.some((ext) => lowerFileName.endsWith(ext));
}

export function isWordFile(fileName) {
  const lower = fileName.toLowerCase();
  return lower.endsWith('.doc') || lower.endsWith('.docx');
}

export function isExcelFile(fileName) {
  const lower = fileName.toLowerCase();
  return lower.endsWith('.xls') || lower.endsWith('.xlsx');
}

export function isTextFile(fileName) {
  return fileName.toLowerCase().endsWith('.txt');
}
