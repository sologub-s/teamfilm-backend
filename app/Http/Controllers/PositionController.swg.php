<?php

    /**
     * @SWG\Get(path="/position/{id}",
     *   tags={"position"},
     *   summary="Return Position by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="PositionController@get",
     *   security={{"X-Auth":{}}},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="project id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="project",
     *         ref="#/definitions/Position"
     *       ),
     *     )
     *   )
     * )
     */
    //public function get(String $id);

    /**
     * @SWG\Get(path="/position/list",
     *   tags={"position"},
     *   summary="Return Positions by criteria",
     *   description="Returns a map of status codes to quantities",
     *   operationId="PositionController@getList",
     *   security={{"X-Auth":{}}},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="order_by",
     *     type="string",
     *     in="path",
     *     description="Criteria compatible order_by i.e. '-created_at,votes,name'",
     *     required=false
     *   ),
     *   @SWG\Parameter(
     *     name="filter",
     *     type="array",
     *     items="string",
     *     in="path",
     *     description="Criteria compatible filter i.e. 'filter[user_id]=591f2171ea6406591715f662&filter[genres]=__in__porn,cartoons&filter[genres]=__nin__horror'",
     *     required=false
     *   ),
     *   @SWG\Parameter(
     *     name="page",
     *     type="integer",
     *     in="path",
     *     description="Criteria compatible page number i.e. '2', default: 1",
     *     required=false
     *   ),
     *   @SWG\Parameter(
     *     name="limit",
     *     type="integer",
     *     in="path",
     *     description="Criteria compatible limit amount i.e. '10', default: 20",
     *     required=false
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       type="array",
     *       @SWG\Property(
     *         property="position",
     *         type="array",
     *         items=@SWG\Schema (ref="#/definitions/Position")
     *       ),
     *       @SWG\Property(
     *         property="criteria",
     *         ref="#/definitions/Criteria"
     *       ),
     *     )
     *   )
     * )
     */
    //public function getList();

    /**
     * @SWG\Post(path="/position",
     *   tags={"position"},
     *   summary="Register Position and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="PositionController@post",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="position",
     *     type="string",
     *     in="body",
     *     description="Position model",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="position", ref="#/definitions/Position"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="position",
     *         ref="#/definitions/Position"
     *       ),
     *     )
     *   )
     * )
     *
     */
    //public function post();

    /**
     * @SWG\Patch(path="/position",
     *   tags={"position"},
     *   summary="Change Position and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="PositionController@patch",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="position",
     *     type="string",
     *     in="body",
     *     description="A part of Position model - any non-protected fields",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="position", ref="#/definitions/Position"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="position",
     *         ref="#/definitions/Position"
     *       )
     *     )
     *   )
     * )
     *
     */
    //public function patch(String $id);

    /**
     * @SWG\Delete(path="/position/{id}",
     *   tags={"project"},
     *   summary="Delete Position by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="PositionController@delete",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="position id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     *
     */
    //public function delete(String $id);
