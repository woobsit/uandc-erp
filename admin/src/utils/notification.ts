import { notification } from 'ant-design-vue';

export type NotificationType = 'success' | 'info' | 'warning' | 'error';

export interface NotifyOptions {
  type: NotificationType;
  message: string;
  description?: string;
  duration?: number; // in seconds; default is 4.5
}

export function notify({
  type,
  message,
  description,
  duration = 4.5,
}: NotifyOptions): void {
  notification[type]({
    message,
    description,
    duration,
  });
}
