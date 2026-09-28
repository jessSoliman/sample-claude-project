// A top-level import is required so this file augments '@inertiajs/core' instead of replacing it.
import type { FlashMessages, SharedPageProps } from '@/core/types/app';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: SharedPageProps;
        flashDataType: FlashMessages;
        errorValueType: string;
    }
}
