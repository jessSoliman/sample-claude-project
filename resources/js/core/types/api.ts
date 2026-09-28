/**
 * The JSON envelope every API endpoint responds with:
 * { success, status_code, message, data }  (see app/Http/Responses/ApiEnvelope.php).
 */

export type ValidationErrors = Record<string, string[]>;

export interface ApiFailureData {
    errors?: ValidationErrors;
}

export interface ApiSuccess<T> {
    success: true;
    status_code: number;
    message: string;
    data: T;
}

export interface ApiFailure {
    success: false;
    /** 0 when the request never reached the server (network failure). */
    status_code: number;
    message: string;
    data: ApiFailureData | null;
}

export type ApiEnvelope<T> = ApiSuccess<T> | ApiFailure;

/** Cursor-paginated list payload used by feeds, profiles and comment threads. */
export interface CursorPage<T> {
    items: T[];
    next_cursor: string | null;
}
