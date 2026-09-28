/**
 * Contracts for the app-wide UI services shared through provide/inject.
 */

export type NotificationKind = 'success' | 'error' | 'info';

export interface AppNotification {
    id: number;
    kind: NotificationKind;
    message: string;
}

export interface NotificationService {
    /** Reactive, oldest first. */
    readonly items: readonly AppNotification[];
    notify(kind: NotificationKind, message: string, timeoutMs?: number): number;
    success(message: string): number;
    error(message: string): number;
    info(message: string): number;
    dismiss(id: number): void;
}

export interface ConfirmOptions {
    title: string;
    message: string;
    confirmLabel?: string;
    cancelLabel?: string;
    /** Styles the confirm button as destructive. */
    destructive?: boolean;
}

export type ConfirmFn = (options: ConfirmOptions) => Promise<boolean>;

/** provide/inject keys (string keys per team standard: inject<T>('key')). */
export const NOTIFICATIONS_KEY = 'notifications';
export const CONFIRM_KEY = 'confirm';
