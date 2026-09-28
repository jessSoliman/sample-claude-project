import type { AuthUser } from '@/core/types/models';

/**
 * Props shared with every Inertia page by app/Http/Middleware/HandleInertiaRequests.php.
 */

export interface BrandColors {
    primary: string;
    primary_contrast: string;
    accent: string;
}

export interface BrandFeatures {
    registration: boolean;
    comments: boolean;
}

export interface BrandConfig {
    id: string;
    name: string;
    tagline: string;
    colors: BrandColors;
    features: BrandFeatures;
}

export interface ContentLimits {
    photo_max_kb: number;
    /** File extensions, e.g. ['jpg', 'png']. */
    photo_mimes: string[];
    caption_max_length: number;
    comment_max_length: number;
}

export interface SharedPageProps {
    auth: {
        user: AuthUser | null;
    };
    brand: BrandConfig;
    limits: ContentLimits;
}

/**
 * One-time messages set server-side with Inertia::flash('success' | 'error', ...).
 * Inertia v3 exposes them on the top-level page object (usePage().flash), not in props.
 */
export interface FlashMessages {
    success?: string;
    error?: string;
}
