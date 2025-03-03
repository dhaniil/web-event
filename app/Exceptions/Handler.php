
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // ...existing code...

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            if ($this->isHttpException($e)) {
                $statusCode = $e->getStatusCode();
                
                if ($statusCode === 500) {
                    return response()->view('errors.500', [
                        'message' => app()->environment('production') ? 'Server Error' : $e->getMessage()
                    ], 500);
                }

                if ($statusCode === 404) {
                    return response()->view('errors.404', [], 404);
                }
            }
            
            if (app()->environment('production')) {
                return response()->view('errors.500', ['message' => 'Server Error'], 500);
            }
            
            return null;
        });
    }
}
