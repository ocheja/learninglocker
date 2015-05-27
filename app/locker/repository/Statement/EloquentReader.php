<?php namespace Locker\Repository\Statement;

use \Illuminate\Database\Eloquent\Model as Model;
use \Locker\Helpers\Helpers as Helpers;

abstract class EloquentReader {
  protected $model = '\Statement';

  /**
   * Constructs a query restricted by the given options.
   * @param [String => Mixed] $opts
   * @return \Jenssegers\Mongodb\Eloquent\Builder
   */
  protected function where(Options $opts) {
    $scopes = $opts->getOpt('scopes');
    $query = (new $this->model)->where('lrs._id', $opts->getOpt('lrs_id'));

    if (in_array('all', $scopes) || in_array('all/read', $scopes) || in_array('statements/read/mine', $scopes)) {
      // Get all statements.
    } else if (in_array('statements/read/mine', $scopes)) {
      $query = $query->where('client_id', $opts->getOpt('client')->_id);
    } else {
      // Throw exception.
    }
  }

  /**
   * Gets the statement from the model as an Object.
   * @param Model $model
   * @return \stdClass
   */
  protected function formatModel(Model $model) {
    return Helpers::replaceHtmlEntity($model->statement);
  }
}
