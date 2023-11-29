import { NextRequest, NextResponse } from "next/server";
import ApiResponse from "@/lib/http/ApiResponse";
import TagController from "@/services/Tag/Controllers/TagController";

/**
 * Get the specific resource info
 *
 * @param request
 * @param context
 * @param response
 * @constructor
 */
export const GET = async (
	request: NextRequest,
	{params}: { params: { tagId: string } },
	response: NextResponse,
) => {
	try {
		const tagId: number = parseInt(params.tagId);

		return await (new TagController(request, response))
			.show(tagId)

	} catch (error: any) {
		return ApiResponse.error(error, error.message);
	}
};

/**
 * Update the specific resource info
 *
 * @param request
 * @param params
 * @param response
 * @constructor
 */
export const PATCH = async (
	request: NextRequest,
	{ params }: { params: { tagId: string } },
	response: NextResponse
) => {

	try {

		const tagId: number = parseInt(params.tagId);

		return await (new TagController(request, response))
			.update(tagId)

	} catch (error: any) {
		return ApiResponse.error(error, error.message);
	}
};

/**
 * Delete the specific resource
 *
 * @param request
 * @param params
 * @param response
 * @constructor
 */
export const DELETE = async (
	request: NextRequest,
	{ params }: { params: { tagId: string } },
	response: NextResponse
) => {

	try {
		const tagId: number = parseInt(params.tagId);

		return await (new TagController(request, response))
			.delete(tagId)

	} catch (error: any) {
		return ApiResponse.error(error, error.message);
	}
};
