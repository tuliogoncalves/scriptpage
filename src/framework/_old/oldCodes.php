<?

function doQuery(LengthAwarePaginator|Collection $result): array
{
    if ($result instanceof Collection) {
        $result = $result->flatten(1);
    }
    $result = $result->toArray();

    return $result;

    // try {
    //     if ($result instanceof Collection) {
    //         $result = $result->flatten(1);
    //         $result = [
    //             'data' => $result->toArray()
    //         ];
    //     } else {
    //         $result = $result->toArray();
    //     }
    //     $result['message'] = 'Success query.';
    // } catch (Exception $e) {
    //     $result = [
    //         'code' => 500,
    //         'message' => $e->getMessage()
    //     ];
    // }

    // return $result;
}
