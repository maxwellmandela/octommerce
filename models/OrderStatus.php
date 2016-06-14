<?php namespace Octommerce\Octommerce\Models;

use Model;
use System\Models\MailTemplate;

/**
 * OrderStatus Model
 */
class OrderStatus extends Model
{
    // use \October\Rain\Database\Traits\Sortable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'octommerce_octommerce_order_statuses';

    public $timestamps = false;

    public $primaryKey = 'code';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'mail_template' => [
            'System\Models\MailTemplate',
            'key' => 'code',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * Returns an array of template codes and ids.
     * @return array
     */
    public static function listAllTemplates()
    {
        $templates = (array) MailTemplate::lists('code', 'id');

        return $templates;
    }

    public function getTemplateCodeAttribute()
    {
        $template = MailTemplate::find($this->mail_template_id);

        if ($template) {
            return $template->code;
        }
    }
}
