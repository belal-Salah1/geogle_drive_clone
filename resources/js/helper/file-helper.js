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
