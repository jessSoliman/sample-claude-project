/**
 * Domain models as serialized by the Laravel API resources
 * (app/Http/Resources/*). Keys mirror the backend payload exactly (snake_case).
 */

export interface User {
    id: number;
    name: string;
    username: string;
    bio: string | null;
    avatar_initials: string;
    profile_url: string;
    created_at: string;
    /** Present only when the backend counted the user's posts (profile page). */
    posts_count?: number;
}

/** The signed-in user; email is only ever serialized for the user themselves. */
export interface AuthUser extends User {
    email: string;
}

export interface PostPermissions {
    delete: boolean;
}

export interface Post {
    id: number;
    caption: string | null;
    photo_url: string;
    /** Falls back to photo_url until the thumbnail job has finished. */
    thumbnail_url: string;
    photo_width: number | null;
    photo_height: number | null;
    author: User;
    comments_count: number;
    url: string;
    created_at: string;
    can: PostPermissions;
}

export interface CommentPermissions {
    delete: boolean;
}

export interface Comment {
    id: number;
    post_id: number;
    body: string;
    author: User;
    created_at: string;
    can: CommentPermissions;
}
