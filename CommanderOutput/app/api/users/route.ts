import TagController from "@/services/Tag/Controllers/TagController";
import {NextRequest, NextResponse} from "next/server";
import ApiResponse from "@/core/ApiResponse";


/**
 * Get All Resources
 *
 * @param request
 * @param response
 * @constructor
 */
export const GET = async (request: NextRequest, response: NextResponse) => {
	try {

		return await (new TagController(request, response))
			.index()

	} catch (error: any) {
		return ApiResponse.error(error, error.message);
	}
};

/**
 * Create a new Resource
 *
 * @param request
 * @param response
 * @constructor
 */
export const POST = async (
	request: NextRequest,
	response: NextResponse
) => {
	try {

		return await (new TagController(request, response))
			.create()

	} catch (error: any) {
		return ApiResponse.error(error, error.message);
	}
};
