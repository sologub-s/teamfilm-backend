<?php

    /**
     * @SWG\Get(path="/project/{id}",
     *   tags={"project"},
     *   summary="Return Project by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@get",
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
     *         ref="#/definitions/Project"
     *       ),
     *     )
     *   )
     * )
     */
    //public function get(String $id);

    /**
     * @SWG\Get(path="/project/list",
     *   tags={"project"},
     *   summary="Return Projects by criteria",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@getList",
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
     *         property="project",
     *         type="array",
     *         items=@SWG\Schema (ref="#/definitions/Project")
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
     * @SWG\Post(path="/project",
     *   tags={"project"},
     *   summary="Register Project and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@post",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="project",
     *     type="string",
     *     in="body",
     *     description="Project model",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="project", ref="#/definitions/Project"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="project",
     *         ref="#/definitions/Project"
     *       ),
     *     )
     *   )
     * )
     *
     */
    //public function post();

    /**
     * @SWG\Patch(path="/project",
     *   tags={"project"},
     *   summary="Change Project and return him",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@patch",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="project",
     *     type="string",
     *     in="body",
     *     description="A part of Project model - any non-protected fields",
     *     required=true,
     *     @SWG\Schema (@SWG\Property(property="project", ref="#/definitions/Project"))
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="project",
     *         ref="#/definitions/Project"
     *       )
     *     )
     *   )
     * )
     *
     */
    //public function patch(String $id);

    /**
     * @SWG\Delete(path="/project/{id}",
     *   tags={"project"},
     *   summary="Delete Project by id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@delete",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="project id, i.e. '591f2171ea6406591715f662'",
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

    /**
     * @SWG\Get(path="/project/{id}/logo",
     *   tags={"project","logo"},
     *   summary="Return Project's logo by project id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@getLogo",
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
     *         property="logo",
     *         ref="#/definitions/Logo"
     *       )
     *     )
     *   )
     * )
     *
     */
    //public function getLogo(String $id);

    /**
     * @SWG\Post(path="/project/logo",
     *   tags={"project","logo"},
     *   summary="Upload logo",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@post",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="logo[]",
     *     type="file",
     *     in="formData",
     *     description="Project's logo",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema (
     *       @SWG\Property(
     *         property="logo",
     *         ref="#/definitions/Logo"
     *       ),
     *     )
     *   )
     * )
     *
     */
    //public function postLogo (String $id);

    /**
     * @SWG\Delete(path="/project/{id}/logo",
     *   tags={"project","logo"},
     *   summary="Delete Project's logo by project id",
     *   description="Returns a map of status codes to quantities",
     *   operationId="ProjectController@deleteLogo",
     *   produces={"application/json"},
     *   security={{"X-Auth":{}}},
     *   @SWG\Parameter(
     *     name="id",
     *     type="string",
     *     in="path",
     *     description="project id, i.e. '591f2171ea6406591715f662'",
     *     required=true
     *   ),
     *   @SWG\Response (
     *     response=200,
     *     description="Success response"
     *   )
     * )
     *
     */
    //public function deleteLogo (String $id);
